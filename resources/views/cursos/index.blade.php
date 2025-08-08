@extends('layouts.plantilla')
@section('title','Cursos')
@section('content')
    <h1>Aqui podras crear un curso pruebas de las pruebas</h1>
    <a href="{{route('cursos.create')}}">Crear curso</a>
    <ul>
        @foreach ($cursos as $curso)
        <li>
            <a href="{{route('cursos.show',$curso->name)}}">{{$curso->name}}</a>
        </li>
        @endforeach
    </ul>
    {{$cursos->links()}}
@endsection