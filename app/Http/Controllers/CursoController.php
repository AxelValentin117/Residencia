<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCurso;
use App\Models\Curso;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class CursoController extends Controller
{
    public function index()
    {
        try {
            $cursos = Curso::orderBy('id', 'desc')->paginate();
            return view('cursos.index', compact('cursos'));
        } catch (Exception $e) {
            Log::error('Error al listar cursos: ' . $e->getMessage());
            return redirect()->back()->with('error', 'No se pudo cargar la lista de cursos.');
        }
    }

    public function create()
    {
        try {
            return view('cursos.create');
        } catch (Exception $e) {
            Log::error('Error al cargar formulario de creación: ' . $e->getMessage());
            return redirect()->back()->with('error', 'No se pudo cargar el formulario de creación.');
        }
    }

    public function store(StoreCurso $request)
    {
        try {
            $curso = Curso::create($request->all());
            return response()->json(['message' => 'Curso Creado Con Exito'], 200);
        } catch (ValidationException $e) {
            Log::error('Error de validación en store Curso: ' . json_encode($e->errors()));
            return response()->json(['message' => 'Error General'],500);
        } catch (Exception $e) {
            Log::error('Error al guardar curso: ' . $e->getMessage());
            
        }
    }

    public function show($id)
    {
        try {
            $curso = Curso::with('cuestionario.preguntas')->findOrFail($id);
            return view('cursos.show', compact('curso'));
        } catch (Exception $e) {
            Log::error('Error al mostrar curso: ' . $e->getMessage());
            return redirect()->back()->with('error', 'No se pudo mostrar el curso.');
        }
    }

    public function edit(Curso $curso)
    {
        try {
            return view('cursos.edit', compact('curso'));
        } catch (Exception $e) {
            Log::error('Error al cargar formulario de edición: ' . $e->getMessage());
            return redirect()->back()->with('error', 'No se pudo cargar el formulario de edición.');
        }
    }

    public function update(Request $request, Curso $curso)
    {
        try {
            $request->validate([
                'name' => 'required',
                'descripcion' => 'required',
                'categoria' => 'required'
            ]);

            $curso->update($request->all());
            return response()->json(['message' => 'Actuazizacion Existosa'],200);
        } catch (ValidationException $e) {
            Log::error('Error de validación en update Curso: ' . json_encode($e->errors()));
            return response()->json(['message' => 'Mensaje de actuzaliar curso'],500);
        } catch (Exception $e) {
            Log::error('Error al actualizar curso: ' . $e->getMessage());
            return response()->json(['message' => 'Error al actualizar curso'],500);
        }
    }

    public function destroy(Curso $curso)
    {
        try {
            $curso->delete();
            return response()->json(['message' => 'Curso eliminada Correctamente'],200);
        } catch (Exception $e) {
            Log::error('Error al eliminar curso: ' . $e->getMessage());
             return response()->json(['message' => 'No se pudo borrar la pregunta'],500);
        }
    }

    public function cuestionarios($id)
    {
        try {
            $curso = Curso::findOrFail($id);
            return view('cursos.cuestionarios', compact('curso'));
        } catch (Exception $e) {
            Log::error('Error al cargar cuestionarios de curso: ' . $e->getMessage());
            return redirect()->back()->with('error', 'No se pudieron cargar los cuestionarios del curso.');
        }
    }
}