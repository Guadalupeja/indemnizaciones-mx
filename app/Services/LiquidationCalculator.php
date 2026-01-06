<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Employee;

class LiquidationCalculator
{
    /**
     * Indemnización por despido injustificado:
     *  - 3 meses de SDI (arts. 48–50 LFT)
     *  - 20 días por año (cuando procede: ver opciones) con fracción
     *  - Vacaciones + prima 25% proporcionales (año de servicio en curso) (arts. 76 y 80)
     *  - Aguinaldo proporcional (año calendario) (art. 87)
     *  - Prima de antigüedad (art. 162) con tope 2× SM; en despido típico se paga aun con <15 años (opción)
     *  - Ajustes: vacaciones gozadas y aguinaldo ya pagado; sueldos pendientes y otras prestaciones
     *  - Neto estimado (opcional, simplificado)
     */
    public function indemnizacion(Employee $e, array $opt = []): array
    {
        $sd  = (float) $e->daily_salary;
        $sdi = (float) ($e->daily_integrated_salary ?: $e->daily_salary);

        $yearsInt   = $e->start_date->diffInYears($e->end_date);
        $yearsFrac  = $this->yearsExact($e->start_date, $e->end_date);

        // 3 meses
        $threeMonths = $sdi * 90.0;

        // 20 días por año (según supuestos)
        $aplican20 = $this->decideVeinteDiasPorAnio(
            $opt['twenty_mode']         ?? 'auto',
            $opt['contract_type']       ?? 'indefinido',
            (bool)($opt['reinstalacion_valida'] ?? false)
        );
        $twentyPerYear = $aplican20 ? ($sdi * 20.0 * $yearsFrac) : 0.0;

        // Prestaciones proporcionales
        [$vacDays, $vacPay, $vacPremium] = $this->vacacionesProporcionales($e, $sd);
        $aguinaldo = $this->aguinaldoProporcional($e, $sd);

        // Prima de antigüedad (despido: puede pagarse aun con <15 años si así se configura)
        $seniority = $this->primaAntiguedad(
            $e,
            (bool)($opt['seniority_in_despido'] ?? true),   // $pagaSin15Anios
            (bool)($opt['seniority_proportional'] ?? true)  // $proporcional
        );

        // Ajustes por pagos previos
        $vacTakenDays = max(0.0, (float)($opt['vac_days_taken'] ?? 0));
        $vacTakenPay  = $sd * $vacTakenDays;
        $vacTakenPrem = $vacTakenPay * 0.25;

        $aguinaldoDaysPaid = max(0.0, (float)($opt['aguinaldo_days_paid'] ?? 0));
        // Interpretación: “días de aguinaldo ya pagados” -> se descuenta SD × días
        $aguinaldoPaidAmt  = $sd * $aguinaldoDaysPaid;

        $vacPayAdj     = max(0.0, $vacPay     - $vacTakenPay);
        $vacPremAdj    = max(0.0, $vacPremium - $vacTakenPrem);
        $aguinaldoAdj  = max(0.0, $aguinaldo  - $aguinaldoPaidAmt);

        $pendingWages  = max(0.0, (float)($opt['pending_wages']  ?? 0));
        $otherBenefits = max(0.0, (float)($opt['other_benefits'] ?? 0));

        $subtotal = $threeMonths + $twentyPerYear + $vacPayAdj + $vacPremAdj + $aguinaldoAdj + $seniority
                    + $pendingWages + $otherBenefits;

        // Neto (simplificado y opcional)
        $netInfo = $this->netoEstimado($e, $subtotal, $aguinaldoAdj, $opt);

        return [
            'type'               => 'indemnizacion',
            'years'              => $yearsInt,
            'years_fractional'   => round($yearsFrac, 6),

            'three_months'       => round($threeMonths, 2),
            'twenty_per_year'    => round($twentyPerYear, 2),

            'vacation_days'      => round($vacDays, 6),
            'vacation_pay'       => round($vacPayAdj, 2),
            'vacation_premium'   => round($vacPremAdj, 2),
            'aguinaldo'          => round($aguinaldoAdj, 2),
            'seniority_premium'  => round($seniority, 2),

            'pending_wages'      => round($pendingWages, 2),
            'other_benefits'     => round($otherBenefits, 2),

            'total'              => round($subtotal, 2),
            'net'                => $netInfo['net'] ?? null,
            'net_notes'          => $netInfo['notes'] ?? null,

            // Para “Supuestos aplicados”
            'assumptions'        => [
                'contract_type'        => $opt['contract_type']        ?? 'indefinido',
                'reinstalacion_valida' => (bool)($opt['reinstalacion_valida'] ?? false),
                'twenty_mode'          => $opt['twenty_mode']          ?? 'auto',
                'aplican_20dias'       => $aplican20,
                'seniority_in_despido' => (bool)($opt['seniority_in_despido'] ?? true),
                'seniority_proportional'=> (bool)($opt['seniority_proportional'] ?? true),
                'vac_days_taken'       => $vacTakenDays,
                'aguinaldo_days_paid'  => $aguinaldoDaysPaid,
                'estimate_isr'         => (bool)($opt['estimate_isr'] ?? false),
                'isr_rate'             => (float)($opt['isr_rate'] ?? 0),
                'aguinaldo_exempt_days'=> (float)($opt['aguinaldo_exempt_days'] ?? 30),
            ],
        ];
    }

    /**
     * Liquidación / Finiquito:
     *  - Proporcionales (vacaciones + prima 25%, aguinaldo)
     *  - Prima de antigüedad SOLO si ≥15 años (art. 162) — si se marca “proporcional” aplica fracción de año
     *  - Ajustes: vacaciones gozadas y aguinaldo pagado; sueldos pendientes y otras prestaciones
     *  - NO incluye 3 meses ni 20 días/año
     *  - Neto estimado (opcional, simplificado)
     */
    public function liquidacion(Employee $e, array $opt = []): array
    {
        $sd        = (float) $e->daily_salary;
        $yearsInt  = $e->start_date->diffInYears($e->end_date);
        $yearsFrac = $this->yearsExact($e->start_date, $e->end_date);

        // Proporcionales
        [$vacDays, $vacPay, $vacPremium] = $this->vacacionesProporcionales($e, $sd);
        $aguinaldo = $this->aguinaldoProporcional($e, $sd);

        // Prima de antigüedad (solo si ≥15 años)
        $seniority = 0.0;
        if ($yearsInt >= 15) {
            $seniority = $this->primaAntiguedad(
                $e,
                false,        // $pagaSin15Anios
                (bool)($opt['seniority_proportional'] ?? true)   // $proporcional
            );
        }

        // Ajustes por pagos previos
        $vacTakenDays = max(0.0, (float)($opt['vac_days_taken'] ?? 0));
        $vacTakenPay  = $sd * $vacTakenDays;
        $vacTakenPrem = $vacTakenPay * 0.25;

        $aguinaldoDaysPaid = max(0.0, (float)($opt['aguinaldo_days_paid'] ?? 0));
        $aguinaldoPaidAmt  = $sd * $aguinaldoDaysPaid;

        $vacPayAdj     = max(0.0, $vacPay     - $vacTakenPay);
        $vacPremAdj    = max(0.0, $vacPremium - $vacTakenPrem);
        $aguinaldoAdj  = max(0.0, $aguinaldo  - $aguinaldoPaidAmt);

        $pendingWages  = max(0.0, (float)($opt['pending_wages']  ?? 0));
        $otherBenefits = max(0.0, (float)($opt['other_benefits'] ?? 0));

        $subtotal = $vacPayAdj + $vacPremAdj + $aguinaldoAdj + $seniority
                    + $pendingWages + $otherBenefits;

        // Neto (simplificado y opcional)
        $netInfo = $this->netoEstimado($e, $subtotal, $aguinaldoAdj, array_merge($opt, [
    'seniority_gross' => $seniority,    // <- añade esta línea
]));


        return [
            'type'               => 'liquidacion',
            'years'              => $yearsInt,
            'years_fractional'   => round($yearsFrac, 6),

            'three_months'       => 0.0,
            'twenty_per_year'    => 0.0,

            'vacation_days'      => round($vacDays, 6),
            'vacation_pay'       => round($vacPayAdj, 2),
            'vacation_premium'   => round($vacPremAdj, 2),
            'aguinaldo'          => round($aguinaldoAdj, 2),
            'seniority_premium'  => round($seniority, 2),

            'pending_wages'      => round($pendingWages, 2),
            'other_benefits'     => round($otherBenefits, 2),

            'total'              => round($subtotal, 2),
            'net'                => $netInfo['net'] ?? null,
            'net_notes'          => $netInfo['notes'] ?? null,

            'assumptions'        => [
                'seniority_proportional'=> (bool)($opt['seniority_proportional'] ?? true),
                'vac_days_taken'       => $vacTakenDays,
                'aguinaldo_days_paid'  => $aguinaldoDaysPaid,
                'estimate_isr'         => (bool)($opt['estimate_isr'] ?? false),
                'isr_rate'             => (float)($opt['isr_rate'] ?? 0),
                'aguinaldo_exempt_days'=> (float)($opt['aguinaldo_exempt_days'] ?? 30),
            ],
        ];
    }

    /* ======================== LÓGICA DE NEGOCIO ======================== */

    private function decideVeinteDiasPorAnio(string $mode, string $contractType, bool $reinstalacionValida): bool
    {
        if ($mode === 'si') return true;
        if ($mode === 'no') return false;

        // AUTO: regla práctica
        if ($reinstalacionValida) return false;
        // Si el contrato es indefinido o determinado >=1 año, usualmente procede
        return in_array($contractType, ['indefinido','determinado_mas_un_ano'], true);
    }

    /** Vacaciones + prima 25% proporcionales (año de servicio en curso). */
    private function vacacionesProporcionales(Employee $e, float $sd): array
    {
        $fullYears = $e->start_date->diffInYears($e->end_date);
        $currentServiceYear = $fullYears + 1;

        $annivStart = $e->start_date->copy()->addYears($fullYears);
        $annivEnd   = $annivStart->copy()->addYear();

        $daysSinceAnniv  = $annivStart->diffInDays($e->end_date) + 1;
        $daysServiceYear = $annivStart->diffInDays($annivEnd);

        $vacEntitlement = $this->vacationDays($currentServiceYear);
        $ratio          = min(1.0, max(0.0, $daysSinceAnniv / $daysServiceYear));
        $vacDays        = $vacEntitlement * $ratio;

        $vacPay     = $sd * $vacDays;
        $vacPremium = $vacPay * 0.25;

        return [$vacDays, $vacPay, $vacPremium];
    }

    /** Aguinaldo proporcional del año calendario. */
    private function aguinaldoProporcional(Employee $e, float $sd): float
    {
        $yearStart  = $e->end_date->copy()->startOfYear();
        $yearEnd    = $e->end_date->copy()->endOfYear();
        $daysYTD    = $yearStart->diffInDays($e->end_date) + 1;
        $daysInYear = $yearStart->diffInDays($yearEnd) + 1; // 365/366
        return $sd * 15.0 * ($daysYTD / $daysInYear);
    }

    /** Tabla de vacaciones (reforma 2023). */
    private function vacationDays(int $serviceYear): int
    {
        if ($serviceYear <= 1) return 12;
        if ($serviceYear === 2) return 14;
        if ($serviceYear === 3) return 16;
        if ($serviceYear === 4) return 18;
        if ($serviceYear === 5) return 20;
        return 22 + 2 * intdiv($serviceYear - 6, 5);
    }

    /** Prima de antigüedad (art. 162 LFT). */
    private function primaAntiguedad(Employee $e, bool $pagaSin15Anios, bool $proporcional = true): float
    {
        $yearsInt = $e->start_date->diffInYears($e->end_date);
        if (!$pagaSin15Anios && $yearsInt < 15) return 0.0;

        $smZona     = $this->minWage($e->zone);
        $baseDiaria = min((float)$e->daily_salary, 2.0 * $smZona);

        $years = $proporcional ? $this->yearsExact($e->start_date, $e->end_date) : (float)$yearsInt;
        $dias  = 12.0 * $years;

        return $baseDiaria * $dias;
    }

    /** Antigüedad exacta en años (con fracción). */
    private function yearsExact(Carbon $start, Carbon $end): float
    {
        $days = $start->diffInDays($end);
        return $days / 365.2425; // promedio astronómico
    }

    /** Salario mínimo por zona desde .env (defaults). */
    private function minWage(?string $zone): float
    {
        $gen = (float) env('MIN_WAGE_GENERAL', 315.04);
        $frn = (float) env('MIN_WAGE_FRONTERA', 440.87);
        return ($zone === 'frontera') ? $frn : $gen;
    }

    /** Neto estimado simplificado (opcional). */
    private function netoEstimado(Employee $e, float $subtotal, float $aguinaldoAdj, array $opt): array
{
    if (!(bool)($opt['estimate_isr'] ?? false)) {
        return ['net' => null, 'notes' => null];
    }

    // Parámetros desde .env
    $umaDaily = (float) env('UMA_VALUE_DAILY', 113.14);          // placeholder: UMA 2025
    $aguinaldoExemptUMA = (float) env('AGUINALDO_EXEMPT_UMA', 30);
    $seniorityExemptUMA = (float) env('SENIORITY_EXEMPT_UMA', 90);

    // Tasa “promedio” configurable (sigue tu enfoque simplificado)
    $rate = max(0.0, min(35.0, (float)($opt['isr_rate'] ?? 0))) / 100.0;

    // 1) Exento de aguinaldo por UMA (NO por “días”)
    $exentoAguinaldo = $umaDaily * $aguinaldoExemptUMA;
    $gravableAguinaldo = max(0.0, $aguinaldoAdj - $exentoAguinaldo);

    // 2) Intento de separar prima de antigüedad si el front la envía (opcional)
    $seniorityGross = max(0.0, (float)($opt['seniority_gross'] ?? 0.0));
    $seniorityExempt = min($seniorityGross, $umaDaily * $seniorityExemptUMA);
    $seniorityGravable = max(0.0, $seniorityGross - $seniorityExempt);

    // 3) Resto gravable (subtotal incluye aguinaldo y prima)
    $resto = max(0.0, $subtotal - $aguinaldoAdj - $seniorityGross);

    $gravableTotal = $resto + $gravableAguinaldo + $seniorityGravable;
    $retencion = $gravableTotal * $rate;
    $neto = max(0.0, $subtotal - $retencion);

    $notes = 'Neto estimado con tasa promedio y topes vigentes: aguinaldo exento 30 UMA y prima de antigüedad exenta 90 UMA. '
           . 'La determinación real depende de tablas ISR, acumulados y CFDI. Actualiza UMA_VALUE_DAILY cuando INEGI publique la UMA vigente.';

    return ['net' => round($neto, 2), 'notes' => $notes];
}

}
