<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calculation extends Model
{
    protected $fillable = [
        'employee_id',
        'type',
        'result_json',
    ];

    protected $casts = [
        'result_json' => 'array',   // Devuelve un arreglo PHP al leer
    ];

    /** Cada cálculo pertenece a un empleado */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
