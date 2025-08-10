@extends('layouts.plantilla')
@section('title','curso' . $curso->name)
@section('content')
    <h1>Bienvenido al curso {{$curso->name}}</h1>
    <a href="{{route('cursos.index')}}">Volver al cursos</a>  
    <a href="{{route('cursos.edit', $curso)}}">Editar Curso</a>
    <a href="{{route('cursos.cuestionarios', $curso->id)}}">crear cuestionarios</a>
    <p><strong>Categoria:</strong>{{$curso->categoria}}</p>
    <p>{{$curso->descripcion}}</p>
    <form action="{{route('cursos.destroy', $curso)}}" method="POST">
        @csrf
        @method('delete')
        <button type="submit">Eliminar</button>
    </form>

    <h2>Preguntas del cuestionario</h2>

    @if($curso->cuestionario && $curso->cuestionario->preguntas->count() > 0)
    <ul>
        @foreach($curso->cuestionario->preguntas as $pregunta)
            <li>{{ $pregunta->text_pregunta }}</li>
        @endforeach
    </ul>
    @else
    <p>No hay preguntas aún.</p>
    @endif

@endsection