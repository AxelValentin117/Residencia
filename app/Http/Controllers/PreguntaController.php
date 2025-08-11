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
       try{
        $request->validate([
            'titulo' => 'required|string|max:255',
            'preguntas' => 'required|string|max:255',
        ]);
        DB::transaction(function () use ($request, $curso ){
        
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
            'cuestionario_iddd' => $cuestionario->id,
            'text_pregunta' => $request->preguntas,
        ]);

        });
        return redirect()->route('cursos.show', $curso)->with('success', 'Pregunta agregada correctamente');

        }catch (ValidationException $e) {
            Log::error('' . json_encode($e->errors()));

            return redirect()->back()->with('error', 'Hubo un error');
        }
        catch (Exception $e) {
            LOG::ERROR('' . $e->getMessage());
            return redirect()->back()->with('error', 'error general');
        }
    }

    public function edit(Curso $curso, Pregunta $pregunta){
        return view('cursos.editpregunta', compact('curso', 'pregunta'));
    }

    public function update(Request $request, Curso $curso, Pregunta $pregunta){
        $request->validate([
            'text_pregunta' => 'required|string|max:255'
        ]);

        $pregunta->update([
            'text_pregunta' => $request->text_pregunta
        ]);

        return redirect()->route('cursos.show', $curso)
                        ->with('success', 'Pregunta actualizada correctamente.');
    }

    public function destroy(Curso $curso, Pregunta $pregunta){
        $pregunta->delete();

        $cuestionario = $curso->cuestionario;

        if ($cuestionario && $cuestionario->preguntas()->count() === 0) {
            $cuestionario->delete();
        }

        return redirect()->route('cursos.show', $curso)->with('success', 'Pregunta eliminada correctamente.');
    }

    public function editarCuestionario(Curso $curso){
    $cuestionario = $curso->cuestionario;
    $preguntas = $cuestionario ? $cuestionario->preguntas : collect();

    
    return view('cursos.editarcuestionario', compact('curso', 'preguntas'));
    }



}

