<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseTestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'end_type'        => ['required','in:despido,renuncia,mutuo,termino,abandono'],
            'dismissal_cause' => ['required','in:injustificada,justificada,no_sabe,no_aplica'],
            'reinstatement'   => ['required','in:nego_reinstalacion,ofrecio_reinstalacion,no_aplica'],
            'forced_resignation' => ['sometimes','boolean'],
            'discrimination'     => ['sometimes','boolean'],
            'pregnancy'          => ['sometimes','boolean'],
            'harassment'         => ['sometimes','boolean'],
            'contract_type'      => ['required','in:indefinido,determinado,obra'],
        ];
    }

    public function attributes(): array
    {
        return [
            'end_type'        => 'forma de terminación',
            'dismissal_cause' => 'causa del despido',
            'reinstatement'   => 'reinstalación',
            'contract_type'   => 'tipo de contrato',
        ];
    }
}
