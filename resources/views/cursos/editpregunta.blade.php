@extends('layouts.plantilla')

@section('title', 'Editar pregunta')

@section('content')
    <h1>Editar pregunta en: {{ $curso->name }}</h1>

    <form action="{{ route('preguntas.update', [$curso, $pregunta]) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="text_pregunta">Pregunta:</label><br>
        <textarea name="text_pregunta" id="text_pregunta" rows="5" required>{{ old('text_pregunta', $pregunta->text_pregunta) }}</textarea>
        <br><br>

        <button type="submit">Actualizar pregunta</button>
    </form>

    <br>
    <a href="{{ route('preguntas.editarcuestionario', $curso) }}">Volver al cuestionario</a>
@endsection
