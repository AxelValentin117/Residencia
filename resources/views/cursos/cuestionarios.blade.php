@extends('layouts.plantilla')
@section('title','cursos cuestionarios')
@section('content')
    <h1>En este cuestionario podras crear preguntas para el curso: {{$curso->name}}</h1>
    <form action="{{route('cursos.update', $curso)}}" method="post">
        @csrf
        @method('put')
        <label>
             Deja tu pregunata: 
            <br>
            <textarea name="preguntas" rows= "5"></textarea>
        </label>
        <br>
        <button type="submit">Actualizar Formulario</button>
    </form>

@endsection