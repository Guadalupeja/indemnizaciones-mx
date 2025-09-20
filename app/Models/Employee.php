<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    // Campos que se pueden asignar masivamente (mass‑assignment)
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'daily_salary',
        'daily_integrated_salary',
        'zone',
    ];

    // Convierte automáticamente a Carbon (fechas) o float/array
    protected $casts = [
        'start_date'              => 'date',
        'end_date'                => 'date',
        'daily_salary'            => 'decimal:2',
        'daily_integrated_salary' => 'decimal:2',
    ];

    /* Relaciones ---------------------------------------------------------- */

    /** Un empleado puede tener muchos cálculos */
    public function calculations(): HasMany
    {
        return $this->hasMany(Calculation::class);
    }
}

