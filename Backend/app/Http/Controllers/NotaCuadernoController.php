<?php

namespace App\Http\Controllers;

use App\Models\NotaCuaderno;
use Illuminate\Http\Request;

class NotaCuadernoController extends Controller
{
    public function notaCuaderno(Request $request)
    {
        $request->validate([
            'ID_Cuaderno' => 'required|integer',
            'ID_Tutor' => 'required|integer',
            'Nota' => 'required|numeric|min:0|max:10',
        ]);

        // Actualizar si ya existe o crear si no
        $nota = NotaCuaderno::updateOrCreate(
            [
                'ID_Cuaderno' => $request->ID_Cuaderno,
                'ID_Tutor' => $request->ID_Tutor
            ],
            [
                'Nota' => $request->Nota,
                'Fecha' => now()
            ]
        );

        return response()->json([
            'success' => true,
            'message' => $nota->wasRecentlyCreated ? 'Nota creada correctamente' : 'Nota actualizada correctamente',
            'data' => $nota
        ]);
    }
}
