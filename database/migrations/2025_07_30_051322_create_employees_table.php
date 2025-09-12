<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('employees', function (Blueprint $table) {
        $table->string('name')->after('id');
        $table->date('start_date')->after('name');
        $table->date('end_date')->nullable()->after('start_date');
        $table->decimal('daily_salary', 8, 2)->after('end_date');
        $table->decimal('daily_integrated_salary', 8, 2)->nullable()
              ->after('daily_salary');
        $table->enum('zone', ['general','frontera'])->default('general')
              ->after('daily_integrated_salary');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()

    {
    Schema::table('employees', function (Blueprint $table) {
        $table->dropColumn([
            'name',
            'start_date',
            'end_date',
            'daily_salary',
            'daily_integrated_salary',
            'zone',
        ]);
    });
}




};
