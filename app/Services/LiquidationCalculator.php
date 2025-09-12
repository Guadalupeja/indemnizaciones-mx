<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Employee;

class LiquidationCalculator
{
    /**                               
     * Cálculo principal (arts. 48-50 LFT)               
     * @return array<string,float>  Montos detallados y total              
     */                               
    public function indemnizacion(Employee $e): array
    {
        // 1) Años completos de servicio (mínimo 1)
        $years = max(1, $e->start_date->diffInYears($e->end_date));

        // 2) Salario Diario Integrado (SDI) recomendado; si no se capturó, usar salario diario
        $sdi = $e->daily_integrated_salary ?: $e->daily_salary;

        /* ─────────────────── Indemnización constitucional ─────────────────── */
        $threeMonths = $sdi * 90;                         // 3 meses de SDI  :contentReference[oaicite:0]{index=0}
        $twentyPerYear = $sdi * 20 * $years;              // +20 días por cada año :contentReference[oaicite:1]{index=1}

        /* ─────────────────── Prestaciones proporcionales ─────────────────── */
        // Días transcurridos en el año corriente (para aguinaldo y vacaciones)
        $yearStart     = Carbon::parse($e->end_date)->startOfYear();
        $daysThisYear  = $yearStart->diffInDays($e->end_date) + 1;

        // 2.1 Vacaciones según art. 76 reformado (12 días el 1.er año…) :contentReference[oaicite:2]{index=2}
        $vacDays       = $this->vacationDays($years) * ($daysThisYear / 365);
        $vacPay        = $sdi * $vacDays;                 // Salario de vacaciones
        $vacPremium    = $vacPay * 0.25;                  // Prima 25 % art. 80 :contentReference[oaicite:3]{index=3}

        // 2.2 Aguinaldo proporcional — 15 días de salario / 365 art. 87 :contentReference[oaicite:4]{index=4}
        $aguinaldo     = $sdi * 15 * ($daysThisYear / 365);

        /* ─────────────────── Total ─────────────────── */
        $total = $threeMonths + $twentyPerYear + $vacPay + $vacPremium + $aguinaldo;

        return [
            'three_months'     => round($threeMonths, 2),
            'twenty_per_year'  => round($twentyPerYear, 2),
            'vacation_pay'     => round($vacPay, 2),
            'vacation_premium' => round($vacPremium, 2),
            'aguinaldo'        => round($aguinaldo, 2),
            'total'            => round($total, 2),
        ];
    }

    /**
     * Devuelve los días de vacaciones totales según años completos de servicio.
     * Reforma 2023 (vigente desde 01-ene-2023). arts. 76-78.
     */
    private function vacationDays(int $years): int
    {
        if ($years === 1) return 12;
        if ($years === 2) return 14;
        if ($years === 3) return 16;
        if ($years === 4) return 18;
        if ($years === 5) return 20;

        // A partir del 6.º año: 22 días, y +2 cada 5 años
        return 22 + 2 * intdiv($years - 6, 5);
    }
}

