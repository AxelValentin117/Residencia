@extends('layouts.plantilla')

@section('title','Curso: ' . $curso->name)

@section('content')
    <div class="mb-4">
        <h1 class="h3">Bienvenido al curso <span class="text-primary">{{ $curso->name }}</span></h1>
    </div>

    {{-- Botones de acciones --}}
    <div class="mb-3 d-flex flex-wrap gap-2">
        <a href="{{ route('cursos.index') }}" class="btn btn-secondary btn-sm">← Volver a cursos</a>
        <a href="{{ route('cursos.edit', $curso) }}" class="btn btn-warning btn-sm">✏️ Editar Curso</a>
        <a href="{{ route('cursos.cuestionarios', $curso->id) }}" class="btn btn-info btn-sm text-white">📝 Crear cuestionarios</a>
    </div>

    {{-- Datos del curso --}}
    <div class="mb-4">
        <p><strong>Categoría:</strong> <span class="badge bg-primary">{{ $curso->categoria }}</span></p>
        <p>{{ $curso->descripcion }}</p>
    </div>

    {{-- Eliminar curso --}}
    <form onsubmit="BorrarCurso(event,this)" 
          action="{{ route('cursos.destroy', $curso) }}" 
          method="POST" 
          class="mb-4">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger"
                onclick="return confirm('¿Eliminar curso?')">
            🗑️ Eliminar Curso
        </button>
    </form>

    {{-- Editar cuestionario --}}
    <div class="mb-4">
        <a href="{{ route('preguntas.editarcuestionario', $curso) }}" class="btn btn-outline-primary">
            ✏️ Editar cuestionario
        </a>
    </div>

    {{-- Preguntas --}}
    <h2 class="h5">Preguntas del cuestionario</h2>

    @if($curso->cuestionario && $curso->cuestionario->preguntas->count() > 0)
        <ul class="list-group mb-4">
            @foreach($curso->cuestionario->preguntas as $pregunta)
                <li class="list-group-item">{{ $pregunta->text_pregunta }}</li>
            @endforeach
        </ul>
    @else
        <div class="alert alert-info">No hay preguntas aún.</div>
    @endif

    {{-- Script de eliminación con fetch --}}
    <script>
    function BorrarCurso(event, formulario) {
        event.preventDefault();

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
            // Mostrar alert de Bootstrap dinámicamente
            const alert = document.createElement('div');
            alert.className = "alert mt-3 " + (status >= 200 && status < 300 ? "alert-success" : "alert-danger");
            alert.innerText = data.message || "Ocurrió un error";

            document.querySelector('.section-body').prepend(alert);

            if (status >= 200 && status < 300) {
                setTimeout(() => {
                    window.location.href = "{{ route('cursos.index') }}";
                }, 1500);
            }
        })
        .catch(error => {
            console.error(error);
            const alert = document.createElement('div');
            alert.className = "alert alert-danger mt-3";
            alert.innerText = 'No se pudo completar la solicitud';
            document.querySelector('.section-body').prepend(alert);
        });
    }
    </script>
@endsection
