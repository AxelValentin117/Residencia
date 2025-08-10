<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Cuestionario;
use App\Models\Pregunta;

class PreguntaController extends Controller
{
    public function store(Request $request, Curso $curso)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'preguntas' => 'required|string|max:255',
        ]);

        // Buscar o crear cuestionario para el curso
        $cuestionario = $curso->cuestionario;

        if (!$cuestionario) {
            $cuestionario = Cuestionario::create([
                'curso_id' => $curso->id,
                'titulo' => $request->titulo,
            ]);
        } else {
            $cuestionario->update(['titulo' => $request->titulo]);
        }

        // Crear pregunta relacionada
        Pregunta::create([
            'cuestionario_id' => $cuestionario->id,
            'text_pregunta' => $request->preguntas,
        ]);

        return redirect()->route('cursos.show', $curso)->with('success', 'Pregunta agregada correctamente');

    }
}

