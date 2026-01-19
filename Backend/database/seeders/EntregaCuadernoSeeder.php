<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntregaCuadernoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('entrega_cuaderno')->insert([
            [
                'id' => 1,
                'fecha_creacion' => '2026-01-02',
                'fecha_limite' => '2026-01-09',
                'id_grado' => 1,
                'descripcion' => 'Cuaderno semana 1: introducción y objetivos'
            ],
            [
                'id' => 2,
                'fecha_creacion' => '2026-01-02',
                'fecha_limite' => '2026-01-09',
                'id_grado' => 2,
                'descripcion' => 'Cuaderno semana 1: normas de la empresa'
            ],
            [
                'id' => 3,
                'fecha_creacion' => '2026-01-06',
                'fecha_limite' => '2026-01-13',
                'id_grado' => 1,
                'descripcion' => 'Cuaderno semana 2: tareas realizadas'
            ],
            [
                'id' => 4,
                'fecha_creacion' => '2026-01-13',
                'fecha_limite' => '2026-01-20',
                'id_grado' => 1,
                'descripcion' => 'Cuaderno semana 3: herramientas utilizadas'
            ],
            [
                'id' => 5,
                'fecha_creacion' => '2026-01-13',
                'fecha_limite' => '2026-01-20',
                'id_grado' => 2,
                'descripcion' => 'Cuaderno semana 2: seguimiento del tutor'
            ],
            [
                'id' => 6,
                'fecha_creacion' => '2026-01-20',
                'fecha_limite' => '2026-01-27',
                'id_grado' => 1,
                'descripcion' => 'Cuaderno semana 4: incidencias y conclusiones'
            ],
        ]);
    }
}
