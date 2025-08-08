@extends('layouts.plantilla')
@section('title','cursos edit')
@section('content')
    <h1>En esta pagina podras editar un curso de esta nueva version</h1>
    <form action="{{route('cursos.update', $curso)}}" method="post">
        @csrf
        @method('put')
        <label>
            Nombre:
            <br>
            <input type="text" name="name" value="{{$curso->name}}">
        </label>

        @error('name')
        {[$message]}
        @enderror
        
        <br>
        <label>
            Descripcion:
            <br>
            <textarea name="descripcion" rows= "5">{{$curso->descripcion}}</textarea>
        </label>
        <br>
        <label>
            Categoria:
            <br>
            <input type="text" name="categoria" value = "{{$curso->categoria}}">
        </label>
        <button type="submit">Actualizar Formulario</button>
    </form>

@endsection