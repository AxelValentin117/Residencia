@extends('layouts.plantilla')

@section('title', 'Editar cuestionario - ' . $curso->name)

@section('content')
    <h1>Editar cuestionario: {{ $curso->name }}</h1>

    @if(session('success'))
        <div style="">{{ session('success') }}</div>
    @endif

    @if($preguntas->count())
        <ul>
            @foreach($preguntas as $pregunta)
                <li>
                    {{ $pregunta->text_pregunta }}
                    <br>
                    <a href="{{ route('preguntas.edit', [$curso, $pregunta]) }}">Editar</a>
                    <form action="{{ route('preguntas.destroy', [$curso, $pregunta]) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Eliminar pregunta?')">Eliminar</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p>No hay preguntas aún.</p>
    @endif
@endsection
