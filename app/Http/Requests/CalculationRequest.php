<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculationRequest extends FormRequest
{
    // ✅ Permite la acción (si no usas gates/policies)
    public function authorize(): bool
    {
        return true; // <- aquí estaba el 403
    }

    public function rules(): array
    {
        return [
            'calc_type'    => ['required','in:indemnizacion,liquidacion'],
            'name'         => ['required','string','max:120'],
            'start_date'   => ['required','date','before_or_equal:end_date'],
            'end_date'     => ['required','date'],
            'daily_salary' => ['required','numeric','gt:0'],
            'sdi'          => ['nullable','numeric','gt:0'],
            'zone'         => ['required','in:general,frontera'],
        ];
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

    // (Opcional) nombres bonitos en los errores
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
