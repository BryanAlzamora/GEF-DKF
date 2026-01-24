<?php

namespace App\Http\Services;

use App\Models\Asignatura;
use App\Models\EstanciaAlumno; 
use App\Models\NotaCuaderno; 
use App\Models\NotaTransversal; 
use App\Models\NotaCompetencia; 
use App\Models\NotaEgibide; 
use App\Models\Ra;
use App\Models\Grado;
use Illuminate\Support\Facades\DB;

class NotasAlumnoService
{

   public function obtenerNotaCuaderno($idAlumno)
    {
        $nota = NotaCuaderno::where('ID_Alumno', $idAlumno)
                    ->value('Nota'); 

        return $nota ? (float)$nota : 0;
    }

  
    public function obtenerNotaTransversal($idAlumno){
        $media = NotaTransversal::where('ID_Alumno', $idAlumno)->avg('Nota');

        if (!$media) {
            return 0;
        }
        return round($media * 2.5, 2); //2.5 porque 4/10 da eso para hacerlo sobre 10 y 2 decimales
    }

       public function obtenerNotasCompetenciasTecnicas($idAlumno) {
        $notas = NotaCompetencia::where('ID_Alumno', $idAlumno)
                    ->pluck('Nota', 'ID_Competencia');
        
        return $notas;
    }
  
    public function obtenerNotaTecnicaPorAsignatura($idAlumno, $asignaturas)
    {
        // 1. Obtener la Nota Transversal (el "comodín")
        // Llamamos a la función que ya creamos antes
        $notaTransversal = $this->obtenerNotaTransversal($idAlumno);

        // 2. Obtener todas las notas de competencias técnicas del alumno de golpe
        // Devuelve un array [ID_Competencia => Nota] (ej: [10 => 3, 11 => 4])
        // Asegúrate de importar el modelo NotaCompetencia arriba
        $notasCompetenciasAlumno = NotaCompetencia::where('ID_Alumno', $idAlumno)
                                    ->pluck('Nota', 'ID_Competencia');

        $notasPorAsignatura = [];

        foreach ($asignaturas as $asig) {
            
            // A. Buscar los RAs de esta asignatura
            $ras = Ra::where('ID_Asignatura', $asig->id)->get();
            
            $mediasDeLosRAs = [];

            foreach ($ras as $ra) {
                // B. Buscar qué competencias tiene este RA en la tabla pivote 'comp_ra'
                $idsCompetenciasDelRa = DB::table('comp_ra')
                                            ->where('ID_Ra', $ra->id)
                                            ->pluck('ID_Comp');
                
                // C. Ver cuáles de esas competencias han sido evaluadas
                $notasDelRa = [];
                foreach ($idsCompetenciasDelRa as $idComp) {
                    if (isset($notasCompetenciasAlumno[$idComp])) {
                        $notasDelRa[] = $notasCompetenciasAlumno[$idComp];
                    }
                }

                // D. Si este RA tiene competencias evaluadas, hacemos su media (sobre 4)
                if (count($notasDelRa) > 0) {
                    $mediaRa = array_sum($notasDelRa) / count($notasDelRa);
                    $mediasDeLosRAs[] = $mediaRa;
                }
            }

            // --- CÁLCULO FINAL DE LA ASIGNATURA ---
            
            if (count($mediasDeLosRAs) > 0) {
                // CASO 1: Hay RAs evaluados. Hacemos la media y convertimos a base 10.
                $mediaAsignaturaSobre4 = array_sum($mediasDeLosRAs) / count($mediasDeLosRAs);
                $notaTecnicaFinal = $mediaAsignaturaSobre4 * 2.5; 
                
                // Guardamos la nota calculada
                $notasPorAsignatura[$asig->id] = round($notaTecnicaFinal, 2);
            } else {
                // CASO 2: No hay RAs evaluados (vacío).
                // AQUI APLICAMOS TU REGLA: Se asigna la nota de transversales.
                $notasPorAsignatura[$asig->id] = $notaTransversal;
            }
        }

        return $notasPorAsignatura;
    }


    public function calcularNotaFinalEmpresa($notaCuaderno, $notaTransversal, $notasTecnicas)
    {
        $notasFinalesEmpresa = [];

        // Recorremos las notas técnicas (que ya están calculadas por asignatura)
        foreach ($notasTecnicas as $idAsignatura => $notaTecnica) {
            
            // Aplicamos la fórmula ponderada
            $calculo = ($notaCuaderno * 0.20) + 
                       ($notaTransversal * 0.20) + 
                       ($notaTecnica * 0.60);

            // Guardamos el resultado redondeado a 2 decimales
            $notasFinalesEmpresa[$idAsignatura] = round($calculo, 2);
        }

        return $notasFinalesEmpresa;
    }

    public function obtenerNotasEgibide($idAlumno)
    {
        $notasEgibide = NotaEgibide::where('ID_Alumno', $idAlumno)
                            ->pluck('nota', 'ID_Asignatura');

        return $notasEgibide;
    }

    public function calcularNotasFinalesPorAsignatura($notasEmpresa, $notasEgibide)
    {
        $notasFinales = [];

        // Recorremos las asignaturas presentes en el array de notas de empresa
        // (Asumimos que notasEmpresa tiene todas las asignaturas del grado calculadas)
        foreach ($notasEmpresa as $idAsignatura => $notaEmpresa) {
            
            // Verificamos si existe nota de Egibide para esta asignatura
            if (isset($notasEgibide[$idAsignatura]) && is_numeric($notasEgibide[$idAsignatura])) {
                
                $notaTutor = $notasEgibide[$idAsignatura];

                // FÓRMULA FINAL
                // 0.2 (20%) de la Nota Empresa + 0.8 (80%) de la Nota Egibide
                $calculoFinal = ($notaEmpresa * 0.20) + ($notaTutor * 0.80);

                $notasFinales[$idAsignatura] = round($calculoFinal, 2);
            } else {
                // Si falta la nota de Egibide, no se puede calcular la final.
                // Devolvemos null o un guion para indicarlo en el frontend.
                $notasFinales[$idAsignatura] = null; 
            }
        }

        return $notasFinales;
    }
   
}
