<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CaseTestRequest;

class CaseTestController extends Controller
{
    /** Muestra el quiz */
    public function form(): View
    {
        return view('casetest.form');
    }

    /** Procesa respuestas y determina el caso */
    public function decide(CaseTestRequest $request): View|RedirectResponse
{
    $endType        = $request->input('end_type');        // 'despido' | 'renuncia' | ...
    $dismissalCause = $request->input('dismissal_cause'); // 'injustificada' | 'justificada' | ...
    $reinstatement  = $request->input('reinstatement');   // 'nego_reinstalacion' | ...
    $forcedResign   = $request->boolean('forced_resignation'); // bool
    $discrimination = $request->boolean('discrimination');     // bool
    $pregnancy      = $request->boolean('pregnancy');           // bool
    $harassment     = $request->boolean('harassment');          // bool
    $contractType   = $request->input('contract_type');   // 'indefinido' | 'determinado' | 'obra'

    $resultType = 'liquidacion';
    $why = [];
    $risk_flags = [];

    if (in_array($endType, ['renuncia','mutuo','termino'], true)) {
        if ($forcedResign) {
            $resultType = 'indemnizacion';
            $why[] = 'Reportas renuncia forzada, lo cual suele tratarse como despido.';
        } else {
            $resultType = 'liquidacion';
            $why[] = 'Relación terminada por renuncia, mutuo acuerdo o vencimiento del contrato.';
        }
    }

    if ($endType === 'despido' || $forcedResign) {
        if ($dismissalCause === 'injustificada' || $dismissalCause === 'no_sabe') {
            $resultType = 'indemnizacion';
            $why[] = 'Despido sin causa justificada acreditada.';
        }
        if ($reinstatement === 'nego_reinstalacion') {
            $resultType = 'indemnizacion';
            $why[] = 'El patrón negó la reinstalación.';
        }
        if ($dismissalCause === 'justificada') {
            if ($discrimination) { $resultType = 'indemnizacion'; $risk_flags[] = 'Posible discriminación.'; }
            if ($pregnancy)      { $resultType = 'indemnizacion'; $risk_flags[] = 'Embarazo/maternidad protegida.'; }
            if ($harassment)     { $resultType = 'indemnizacion'; $risk_flags[] = 'Acoso u hostigamiento.'; }
            if ($resultType === 'liquidacion') {
                $why[] = 'El patrón alega causa justificada; en principio no habría indemnización.';
            }
        }
    }

    if ($contractType === 'determinado' && $endType === 'termino') {
        $resultType = 'liquidacion';
        $why[] = 'El contrato por tiempo determinado venció.';
    }

    $cta = [
        'label' => $resultType === 'indemnizacion' ? 'Calcular mi indemnización' : 'Calcular mi finiquito',
        'url'   => url('/?calc_type=' . ($resultType === 'indemnizacion' ? 'indemnizacion' : 'liquidacion')),
    ];

    return view('casetest.result', [
        'answers'     => $request->validated(),
        'result_type' => $resultType,
        'why'         => $why,
        'risk_flags'  => $risk_flags,
        'cta'         => $cta,
    ]);
}

}
