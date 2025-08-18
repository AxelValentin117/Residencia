@extends('layouts.plantilla')
@section('title','curso ' . $curso->name)

@section('content')
    <h1>Bienvenido al curso {{ $curso->name }}</h1>

    <a href="{{ route('cursos.index') }}">Volver al cursos</a>  
    <a href="{{ route('cursos.edit', $curso) }}">Editar Curso</a>
    <a href="{{ route('cursos.cuestionarios', $curso->id) }}">Crear cuestionarios</a>

    <p><strong>Categoria:</strong> {{ $curso->categoria }}</p>
    <p>{{ $curso->descripcion }}</p>

    <form onsubmit="BorrarCurso(event,this)" action="{{ route('cursos.destroy', $curso) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('¿Eliminar curso?')">Eliminar</button>
    </form>

    <br>
    <a href="{{ route('preguntas.editarcuestionario', $curso) }}">Editar cuestionario</a>
    <br>

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

    <script>
    function BorrarCurso(event, formulario) {
        event.preventDefault(); // Evita el envío normal del form

        const formData = new FormData(formulario);
        const token = formData.get('_token');

        fetch(formulario.action, {
            method: 'POST', // Laravel respeta _method=DELETE
            headers: {
                'X-CSRF-TOKEN': token
            },
            body: formData
        })
        .then(response => {
            const status = response.status;
            return response.json().then(data => ({ status, data }));
        })
        .then(({ status, data }) => {
            alert(data.message);
            if (status >= 200 && status < 300) {
                window.location.href = "{{ route('cursos.index') }}";
            }
        })
        .catch(error => {
            alert('No se pudo completar la solicitud');
            console.error(error);
        });
    }
    </script>
@endsection
