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
        // Empleado
        $employee = Employee::updateOrCreate(
            [
                'name'       => $request->string('name'),
                'start_date' => $request->date('start_date'),
                'end_date'   => $request->date('end_date'),
            ],
            [
                'daily_salary'            => $request->float('daily_salary'),
                'daily_integrated_salary' => $request->input('sdi') ?: null,
                'zone'                    => $request->string('zone'),
            ]
        );

        $type = $request->input('calc_type', 'indemnizacion');

        // Cálculo según tipo
        if ($type === 'liquidacion') {
            $data = $service->liquidacion($employee);
        } else {
            $data = $service->indemnizacion($employee);
            $type = 'indemnizacion';
        }

        // Guarda
        Calculation::create([
            'employee_id' => $employee->id,
            'type'        => $type,
            'result_json' => $data, // cast a array en el modelo
        ]);

        return view('calculator.result', [
            'employee' => $employee,
            'result'   => $data,
            'type'     => $type,
        ]);
    }
}
