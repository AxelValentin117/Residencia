@extends('layouts.plantilla')
@section('title','cursos edit')
@section('content')
    <h1>En esta pagina podras editar un curso</h1>
    <form action="{{route('cursos.update', $curso)}}" method="post">
        @csrf
        <label>
            Nombre:
            <br>
            <input type="text" name="name" value="{{$curso->name}}">
        </label>
        
        <br>
        <label>
            Descripcion:
            <br>
            <textarea name="descripcion" rows= "5" value="{{$curso->descripcion}}"></textarea>
        </label>
        <br>
        <label>
            Categoria:
            <br>
            <input type="text" name="categoria" value = "{{$curso->categoria}}">
        </label>
        <button type="submit">Actualizar Formulario</button>
    </form>
@endsection1