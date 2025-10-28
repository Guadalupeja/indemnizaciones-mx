<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'calc_type'    => ['required','in:indemnizacion,liquidacion'],
            'name'         => ['required','string','max:120'],
            'start_date'   => ['required','date','before_or_equal:end_date'],
            'end_date'     => ['required','date'],
            'daily_salary' => ['required','numeric','gt:0'],
            'sdi'          => ['nullable','numeric','gt:0'],
            'zone'         => ['required','in:general,frontera'],

            // Ajustes comunes
            'vac_days_taken'       => ['nullable','numeric','gte:0'],
            'aguinaldo_days_paid'  => ['nullable','numeric','gte:0'],
            'pending_wages'        => ['nullable','numeric','gte:0'],
            'other_benefits'       => ['nullable','numeric','gte:0'],
            'estimate_isr'         => ['nullable','boolean'],
            'isr_rate'             => ['nullable','numeric','between:0,35'],
            'aguinaldo_exempt_days'=> ['nullable','numeric','gte:0'],
        ];

        // Solo si es indemnización: permitir (no obligar) sus campos
        if ($this->input('calc_type') === 'indemnizacion') {
            $rules = array_merge($rules, [
                'contract_type'        => ['nullable','in:indefinido,determinado_mas_un_ano,determinado_menos_un_ano'],
                'reinstalacion_valida' => ['nullable','boolean'],
                'twenty_mode'          => ['nullable','in:auto,si,no'],
                'seniority_in_despido' => ['nullable','boolean'],
                'seniority_proportional' => ['nullable','boolean'],
            ]);
        } else {
            // En finiquito, solo proporcional (opcional)
            $rules['seniority_proportional'] = ['nullable','boolean'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'calc_type.required' => 'Selecciona el tipo de cálculo.',
            'calc_type.in'       => 'El tipo de cálculo no es válido.',
            'name.required'      => 'El nombre es obligatorio.',
            'daily_salary.gt'    => 'El salario debe ser mayor a cero.',
        ];
    }

    public function attributes(): array
    {
        return [
            'calc_type'    => 'tipo de cálculo',
            'name'         => 'nombre',
            'start_date'   => 'fecha de inicio',
            'end_date'     => 'último día laborado',
            'daily_salary' => 'salario diario',
            'sdi'          => 'salario diario integrado (SDI)',
            'zone'         => 'zona salarial',
        ];
    }
}
