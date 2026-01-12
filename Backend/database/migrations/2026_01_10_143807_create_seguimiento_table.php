<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('seguimiento', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('ID_Estancia');
                    $table->date('Fecha');
                    $table->time('Hora');
                    $table->string('Accion_seguimiento', 150);
                    $table->text('Seguimiento_actividad');
            $table->timestamps();

                    $table->foreign('ID_Estancia')
                        ->references('id')->on('estancia_alumno')
                        ->cascadeOnDelete()
                        ->cascadeOnUpdate();

                });
    }

    public function down(): void {
        Schema::dropIfExists('seguimiento');
    }
};
