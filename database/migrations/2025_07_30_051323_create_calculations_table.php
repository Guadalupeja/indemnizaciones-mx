<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('calculations', function (Blueprint $table) {
        $table->id();

        // Clave foránea que apunta al empleado
        $table->foreignId('employee_id')
              ->constrained()          // por defecto a employees.id
              ->cascadeOnDelete();     // si borras al empleado, borra sus cálculos

        $table->enum('type', [
            'indemnizacion',
            'liquidacion',
            'finiquito',
        ]);

        $table->json('result_json');   // El detalle de la operación: totales, desglose, etc.
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculations');
    }
};
