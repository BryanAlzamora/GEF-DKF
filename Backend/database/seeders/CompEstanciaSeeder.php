<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompEstanciaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('comp_estancia')->insert([
            // =======================================================
            // Estancia 1 (Alumno 20001)
            // =======================================================
            ['id' => 1, 'ID_Comp' => 1, 'ID_Estancia' => 1],
            ['id' => 2, 'ID_Comp' => 2, 'ID_Estancia' => 1],
            ['id' => 3, 'ID_Comp' => 3, 'ID_Estancia' => 1],

            // =======================================================
            // Estancia 2 (Alumno 20002)
            // =======================================================
            ['id' => 4, 'ID_Comp' => 1, 'ID_Estancia' => 2],
            ['id' => 5, 'ID_Comp' => 4, 'ID_Estancia' => 2],
            ['id' => 6, 'ID_Comp' => 6, 'ID_Estancia' => 2],

            // =======================================================
            // Estancia 3 (Alumno 20003)
            // =======================================================
            ['id' => 7, 'ID_Comp' => 8, 'ID_Estancia' => 3],
            ['id' => 8, 'ID_Comp' => 9, 'ID_Estancia' => 3],
            ['id' => 9, 'ID_Comp' => 10, 'ID_Estancia' => 3],

            // =======================================================
            // Estancia 4 (Alumno 20004)
            // =======================================================
            ['id' => 10, 'ID_Comp' => 14, 'ID_Estancia' => 4],
            ['id' => 11, 'ID_Comp' => 15, 'ID_Estancia' => 4],
            ['id' => 12, 'ID_Comp' => 16, 'ID_Estancia' => 4],

            // =======================================================
            // Estancia 5 (Alumno 20005)
            // =======================================================
            ['id' => 13, 'ID_Comp' => 22, 'ID_Estancia' => 5],
            ['id' => 14, 'ID_Comp' => 23, 'ID_Estancia' => 5],
            ['id' => 15, 'ID_Comp' => 24, 'ID_Estancia' => 5],
        ]);
    }
}
