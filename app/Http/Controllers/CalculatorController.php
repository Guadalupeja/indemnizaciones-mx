<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CalculationRequest;
use App\Models\Calculation;
use App\Models\Employee;
use App\Services\LiquidationCalculator;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CalculatorController extends Controller
{
    public function form(): View
    {
        return view('inicio');
    }

    public function calculate(CalculationRequest $request, LiquidationCalculator $service): View|RedirectResponse
    {
        // Empleado (persistimos para historial)
        $employee = Employee::updateOrCreate(
            [
                'name'       => (string) $request->input('name'),
                'start_date' => $request->date('start_date'),
                'end_date'   => $request->date('end_date'),
            ],
            [
                'daily_salary'            => (float) $request->input('daily_salary'),
                'daily_integrated_salary' => $request->filled('sdi') ? (float) $request->input('sdi') : null,
                'zone'                    => (string) $request->input('zone'),
            ]
        );

        $type = $request->input('calc_type', 'indemnizacion');

        // Supuestos comunes
        $options = [
            'vac_days_taken'       => (float) $request->input('vac_days_taken', 0),
            'aguinaldo_days_paid'  => (float) $request->input('aguinaldo_days_paid', 0),
            'pending_wages'        => (float) $request->input('pending_wages', 0),
            'other_benefits'       => (float) $request->input('other_benefits', 0),
            'estimate_isr'         => (bool)  $request->boolean('estimate_isr', false),
            'isr_rate'             => (float) $request->input('isr_rate', 0),
            'aguinaldo_exempt_days'=> (float) $request->input('aguinaldo_exempt_days', 30),
            'seniority_proportional'=> (bool) $request->boolean('seniority_proportional', true),
        ];

        if ($type === 'indemnizacion') {
            // Exclusivos de indemnización
            $options = array_merge($options, [
                'contract_type'         => (string) $request->input('contract_type', 'indefinido'),
                'reinstalacion_valida'  => (bool)   $request->boolean('reinstalacion_valida', false),
                'twenty_mode'           => (string) $request->input('twenty_mode', 'auto'),
                'seniority_in_despido'  => (bool)   $request->boolean('seniority_in_despido', true),
            ]);

            $data = $service->indemnizacion($employee, $options);
            $type = 'indemnizacion';
        } else {
            $data = $service->liquidacion($employee, $options);
            $type = 'liquidacion';
        }

        // Guardar cálculo
        Calculation::create([
            'employee_id' => $employee->id,
            'type'        => $type,
            'result_json' => $data,
        ]);

        return view('calculator.result', [
            'employee' => $employee,
            'result'   => $data,
            'type'     => $type,
        ]);
    }
}
