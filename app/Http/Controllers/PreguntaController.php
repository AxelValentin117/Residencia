<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Cuestionario;
use App\Models\Pregunta;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PreguntaController extends Controller
{
    public function store(Request $request, Curso $curso)
    {
        try {
            $request->validate([
                'titulo' => 'required|string|max:255',
                'preguntas' => 'required|string|max:255',
            ]);

            DB::transaction(function () use ($request, $curso) {
                $cuestionario = $curso->cuestionario;

                if (!$cuestionario) {
                    $cuestionario = Cuestionario::create([
                        'curso_id' => $curso->id,
                        'titulo' => $request->titulo,
                    ]);
                } else {
                    $cuestionario->update(['titulo' => $request->titulo]);
                }

                Pregunta::create([
                    'cuestionario_id' => $cuestionario->id,
                    'text_pregunta' => $request->preguntas,
                ]);
            });
            return response()->json(['message' => 'Mensaje de éxito'], 200);
    

        } catch (ValidationException $e) {
            Log::error('Validación fallida: ' . json_encode($e->errors()));
            return response()->json(['message' => 'Error General'],500);
        } catch (Exception $e) {
            Log::error('Error general: ' . $e->getMessage());
            return response()->json(['message' => 'Mensaje de error'],500);
        }
    }

    public function edit(Curso $curso, Pregunta $pregunta)
    {
        try {
            return view('cursos.editpregunta', compact('curso', 'pregunta'));
        } catch (Exception $e) {
            Log::error('Error al cargar vista de edición: ' . $e->getMessage());
            return redirect()->back()->with('error', 'No se pudo cargar la vista de edición.');
        }
    }

    public function update(Request $request, Curso $curso, Pregunta $pregunta)
    {
        try {
            $request->validate([
                'text_pregunta' => 'required|string|max:255'
            ]);

            $pregunta->update([
                'text_pregunta' => $request->text_pregunta
            ]);
            /*return redirect()->route('cursos.show')->response()->json(['message' => 'Actuazizacion Existosa'],200);*/
            return redirect()->route('cursos.show', $curso)->with('success', 'Pregunta actualizada correctamente.');
        } catch (ValidationException $e) {
            Log::error('Validación fallida en update: ' . json_encode($e->errors()));
            return response()->json(['message' => 'Mensaje de actuzaliar pregunta'],500);
        } catch (Exception $e) {
            Log::error('Error general en update: ' . $e->getMessage());
            return response()->json(['message' => 'Error al actualizar'],500);
        }
    }

    public function destroy(Curso $curso, Pregunta $pregunta)
    {
        try {
            $pregunta->delete();

            $cuestionario = $curso->cuestionario;
            if ($cuestionario && $cuestionario->preguntas()->count() === 0) {
                $cuestionario->delete();
            }

            return redirect()->route('cursos.show', $curso)->with('success', 'Pregunta eliminada correctamente.');
        } catch (Exception $e) {
            Log::error('Error al eliminar pregunta: ' . $e->getMessage());
            return redirect()->back()->with('error', 'No se pudo eliminar la pregunta.');
        }
    }

    public function editarCuestionario(Curso $curso)
    {
        try {
            $cuestionario = $curso->cuestionario;
            $preguntas = $cuestionario ? $cuestionario->preguntas : collect();

            return view('cursos.editarcuestionario', compact('curso', 'preguntas'));
        } catch (Exception $e) {
            Log::error('Error al editar cuestionario: ' . $e->getMessage());
            return redirect()->back()->with('error', 'No se pudo cargar la edición del cuestionario.');
        }
    }
}
