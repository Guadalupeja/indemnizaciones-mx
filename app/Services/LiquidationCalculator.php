<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Employee;

class LiquidationCalculator
{
    /**
     * Indemnización por despido injustificado:
     *  - 3 meses de SDI (arts. 48–50 LFT)
     *  - 20 días por año (cuando procede) con fracción
     *  - Vacaciones + prima 25% proporcionales (año de servicio en curso) (arts. 76 y 80)
     *  - Aguinaldo proporcional (año calendario) (art. 87)
     *  - Prima de antigüedad (art. 162) con tope 2× SM — se paga aun con <15 años
     */
    public function indemnizacion(Employee $e, bool $aplicanVeinteDiasPorAnio = true): array
    {
        $sd  = (float) $e->daily_salary;
        $sdi = (float) ($e->daily_integrated_salary ?: $e->daily_salary);

        // Antigüedad (entera y fraccionaria)
        $yearsInt   = $e->start_date->diffInYears($e->end_date);             // años completos (int)
        $yearsFrac  = $this->yearsExact($e->start_date, $e->end_date);       // p. ej. 3.2986…

        /* ───────── Indemnización constitucional ───────── */
        $threeMonths   = $sdi * 90;
        $twentyPerYear = $aplicanVeinteDiasPorAnio ? ($sdi * 20 * $yearsFrac) : 0.0;

        /* ───────── Prestaciones proporcionales ───────── */
        [$vacDays, $vacPay, $vacPremium] = $this->vacacionesProporcionales($e, $sd);
        $aguinaldo = $this->aguinaldoProporcional($e, $sd);

        /* ───────── Prima de antigüedad (siempre en despido) ───────── */
        $seniority = $this->primaAntiguedad($e, /*pagaSin15Anios=*/true, /*proporcional=*/true);

        $total = $threeMonths + $twentyPerYear + $vacPay + $vacPremium + $aguinaldo + $seniority;

        return [
            'type'              => 'indemnizacion',
            'years'             => $yearsInt,
            'years_fractional'  => round($yearsFrac, 6),
            'three_months'      => round($threeMonths, 2),
            'twenty_per_year'   => round($twentyPerYear, 2),
            'vacation_days'     => round($vacDays, 6),
            'vacation_pay'      => round($vacPay, 2),
            'vacation_premium'  => round($vacPremium, 2),
            'aguinaldo'         => round($aguinaldo, 2),
            'seniority_premium' => round($seniority, 2),
            'total'             => round($total, 2),
        ];
    }

    /**
     * Liquidación / Finiquito (renuncia, término, mutuo acuerdo):
     *  - Vacaciones + prima 25% proporcionales (año de servicio en curso)
     *  - Aguinaldo proporcional (año calendario)
     *  - Prima de antigüedad SOLO si ≥15 años (art. 162)
     */
    public function liquidacion(Employee $e): array
    {
        $sd        = (float) $e->daily_salary;
        $yearsInt  = $e->start_date->diffInYears($e->end_date);
        $yearsFrac = $this->yearsExact($e->start_date, $e->end_date);

        /* ───────── Prestaciones proporcionales ───────── */
        [$vacDays, $vacPay, $vacPremium] = $this->vacacionesProporcionales($e, $sd);
        $aguinaldo = $this->aguinaldoProporcional($e, $sd);

        /* ───────── Prima de antigüedad: solo si ≥ 15 años ───────── */
        $seniority = 0.0;
        if ($yearsInt >= 15) {
            $seniority = $this->primaAntiguedad($e, /*pagaSin15Anios=*/false, /*proporcional=*/true);
        }

        $total = $vacPay + $vacPremium + $aguinaldo + $seniority;

        return [
            'type'              => 'liquidacion',
            'years'             => $yearsInt,
            'years_fractional'  => round($yearsFrac, 6),
            'vacation_days'     => round($vacDays, 6),
            'vacation_pay'      => round($vacPay, 2),
            'vacation_premium'  => round($vacPremium, 2),
            'aguinaldo'         => round($aguinaldo, 2),
            'seniority_premium' => round($seniority, 2),
            'total'             => round($total, 2),
        ];
    }

    /* ======================== Helpers sustantivos ======================== */

    /** Vacaciones + prima 25% proporcionales con base en *año de servicio actual* (aniversario). */
    private function vacacionesProporcionales(Employee $e, float $sd): array
    {
        // Años completos de servicio
        $fullYears = $e->start_date->diffInYears($e->end_date);  // 0,1,2,3…
        $currentServiceYear = $fullYears + 1;                    // 1.º, 2.º, 3.º, 4.º…

        // Aniversario que está corriendo
        $annivStart = $e->start_date->copy()->addYears($fullYears);  // último aniversario
        $annivEnd   = $annivStart->copy()->addYear();                // siguiente aniversario

        // Días transcurridos en el año de servicio
        $daysSinceAnniv   = $annivStart->diffInDays($e->end_date) + 1; // +1 para contar el día de baja
        $daysServiceYear  = $annivStart->diffInDays($annivEnd);        // 365 o 366

        // Días que corresponden al año de servicio actual
        $vacEntitlement = $this->vacationDays($currentServiceYear);    // p. ej. en 4.º año = 18
        $ratio          = min(1.0, max(0.0, $daysSinceAnniv / $daysServiceYear));
        $vacDays        = $vacEntitlement * $ratio;

        $vacPay     = $sd * $vacDays;        // Vacaciones se calculan sobre SD
        $vacPremium = $vacPay * 0.25;        // Prima vacacional 25%

        return [$vacDays, $vacPay, $vacPremium];
    }

    /** Aguinaldo proporcional por año calendario (considera 365/366). */
    private function aguinaldoProporcional(Employee $e, float $sd): float
    {
        $yearStart  = $e->end_date->copy()->startOfYear();
        $yearEnd    = $e->end_date->copy()->endOfYear();
        $daysYTD    = $yearStart->diffInDays($e->end_date) + 1;         // del 1/ene a la baja (incluyente)
        $daysInYear = $yearStart->diffInDays($yearEnd) + 1;             // 365 o 366
        return $sd * 15 * ($daysYTD / $daysInYear);
    }

    /** Días de vacaciones legales según el año de servicio (reforma 2023, arts. 76–78). */
    private function vacationDays(int $serviceYear): int
    {
        if ($serviceYear <= 1) return 12;
        if ($serviceYear === 2) return 14;
        if ($serviceYear === 3) return 16;
        if ($serviceYear === 4) return 18;
        if ($serviceYear === 5) return 20;
        // Desde el 6.º: 22 días, +2 cada 5 años
        return 22 + 2 * intdiv($serviceYear - 6, 5);
    }

    /**
     * Prima de antigüedad (art. 162 LFT).
     * - 12 días por año de servicio; salario base = min(SD, 2× SM por zona).
     * - $pagaSin15Anios: true en despido; false en renuncia (requiere ≥15 años).
     * - $proporcional: si true, paga fracción de año (práctica común).
     */
    private function primaAntiguedad(Employee $e, bool $pagaSin15Anios, bool $proporcional = true): float
    {
        $yearsInt = $e->start_date->diffInYears($e->end_date);

        if (!$pagaSin15Anios && $yearsInt < 15) {
            return 0.0;
        }

        $smZona     = $this->minWage($e->zone);
        $baseDiaria = min((float) $e->daily_salary, 2.0 * $smZona);

        $years = $proporcional
            ? $this->yearsExact($e->start_date, $e->end_date)  // p. ej. 3.2986
            : (float) $yearsInt;

        $dias = 12.0 * $years;   // permite fracción de año
        return $baseDiaria * $dias;
    }

    /** Antigüedad exacta en años (con fracción). Usa días/365 para estabilidad con tus cálculos actuales. */
    private function yearsExact(Carbon $start, Carbon $end): float
    {
        $days = $start->diffInDays($end); // no +1 aquí; buscamos proporción estándar
        return $days / 365.0;
    }

    /** Salario mínimo por zona desde .env (valores por defecto si falta). */
    private function minWage(?string $zone): float
    {
        $gen = (float) env('MIN_WAGE_GENERAL', 248.93);
        $frn = (float) env('MIN_WAGE_FRONTERA', 374.89);
        return ($zone === 'frontera') ? $frn : $gen;
    }
}
