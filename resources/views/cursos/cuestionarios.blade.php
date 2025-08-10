@extends('layouts.plantilla')
@section('title','cursos cuestionarios')
@section('content')
    <h1>En este cuestionario podras crear preguntas para el curso: {{$curso->name}}</h1>
    <form action="{{ route('preguntas.store', $curso) }}" method="POST">
    @csrf

    <label>Título del cuestionario:
    <br>
        <input type="text" name="titulo" value="{{ old('titulo', $curso->cuestionario->titulo ?? '') }}" required>
    </label>
    <br>
    <br>
    <label>Pregunta:
        <br>
        <textarea name="preguntas" rows="5" required></textarea>
    </label>
    <br>

    <button type="submit">Guardar pregunta</button>
</form>


@endsection