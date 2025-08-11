@extends('layouts.plantilla')

@section('title', 'Editar pregunta')

@section('content')
<h1>Editar pregunta</h1>

<form action="{{ route('preguntas.update', $pregunta) }}" method="POST">
    @csrf
    @method('PUT')
    
    <label>
        Pregunta:
        <textarea name="text_pregunta" rows="5" required>{{ old('text_pregunta', $pregunta->text_pregunta) }}</textarea>
    </label>
    <br>

    <button type="submit">Actualizar</button>
</form>
@endsection
