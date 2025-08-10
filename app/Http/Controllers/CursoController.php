<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCurso;
use App\Models\Curso;

use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class CursoController extends Controller
{
    public function index(){
        $cursos = Curso::orderBy('id','desc')->paginate();
        return view('cursos.index', compact('cursos'));
    }
    public function create(){
        return view('cursos.create');
    }

    public function store(StoreCurso $request){
        $curso  = Curso::create($request->all());
        return redirect()->route('cursos.show',$curso);
    }

    public function show($id){
        $curso = Curso::with('cuestionario.preguntas')->findOrFail($id);
        $curso = Curso::find($id);
        return view('cursos.show',compact('curso'));
    }

    public function edit(Curso $curso){
        return view('cursos.edit', compact('curso'));
    }

    public function update(Request $request, Curso $curso){
        $request->validate([
            'name'=>'required',
            'descripcion' => 'required',
            'categoria' => 'required'
        ]);

        $curso->update($request->all());
        return redirect()->route('cursos.show', $curso);
    }

    public function destroy(Curso $curso){
        $curso->delete();

        return redirect()->route('cursos.index');
    }

    public function cuestionarios($id){
        $curso = Curso::findOrfail($id);
        return view('cursos.cuestionarios', compact('curso'));
    }

    
}