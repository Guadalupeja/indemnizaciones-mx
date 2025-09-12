<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CalculationRequest;   // (lo crearemos enseguida)
use App\Models\Calculation;
use App\Models\Employee;
use App\Services\LiquidationCalculator;     // el servicio de la sección 7
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class CalculatorController extends Controller
{
    /**
     * Muestra el formulario de cálculo.
     */
    public function form(): View
    {
        return view('inicio');
    }

    /**
     * Procesa los datos del usuario, guarda el cálculo y muestra el resultado.
     */
    public function calculate(CalculationRequest $request,
                              LiquidationCalculator $service): View|RedirectResponse
    {
        // 1. Crea/actualiza al empleado
        $employee = Employee::updateOrCreate(
            [
                'name'       => $request->input('name'),
                'start_date' => $request->input('start_date'),
                'end_date'   => $request->input('end_date'),
            ],
            [
                'daily_salary'            => $request->input('daily_salary'),
                'daily_integrated_salary' => $request->input('sdi'),
                'zone'                    => $request->input('zone'),
            ]
        );
$type = $request->input('calc_type', 'indemnizacion');

        // 2. Usa el servicio para obtener los montos
        $data = $service->indemnizacion($employee);

        // 3. Guarda el resultado (JSON) en la tabla calculations
        Calculation::create([
            'employee_id' => $employee->id,
            'type'        => 'indemnizacion',
            'result_json' => json_encode($data),
        ]);

        // 4. Regresa la vista con los datos
        return view('calculator.result', [
            'employee' => $employee,
            'result'   => $data,
                'type'     => $type, // ← importante

        ]);
    }
}