<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comp_estancia', function (Blueprint $table) {
            $table->id();

            // FK a competencias
            $table->foreignId('ID_Comp')
                  ->constrained('competencia')
                  ->cascadeOnDelete();

            // FK a estancia_alumno
            $table->foreignId('ID_Estancia')
                  ->constrained('estancia_alumno')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comp_estancia');
    }
};
