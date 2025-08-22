@extends('layouts.plantilla')

@section('title', 'Editar cuestionario - ' . $curso->name)

@section('content')
    <h1 class="h4 mb-4">Editar cuestionario de: <span class="text-primary">{{ $curso->name }}</span></h1>

    {{-- Mensajes de éxito --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if($preguntas->count())
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <strong>Preguntas del cuestionario</strong>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Pregunta</th>
                            <th scope="col" class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($preguntas as $pregunta)
                            <tr>
                                <td>{{ $pregunta->text_pregunta }}</td>
                                <td class="text-end">
                                    <a href="{{ route('preguntas.edit', [$curso, $pregunta]) }}" class="btn btn-sm btn-warning">
                                        Editar
                                    </a>
                                    <form onsubmit="BorrarCuestionario(event,this)" 
                                          action="{{ route('preguntas.destroy', [$curso, $pregunta]) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar pregunta?')">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('cursos.show', $curso) }}" class="btn btn-secondary">
                Volver al cuestionario
            </a>
        </div>
    @else
        <div class="alert alert-info">
            No hay preguntas aún.
        </div>
    @endif

    <script>
    function BorrarCuestionario(event, formulario){
        event.preventDefault(); // Evitamos el envío del formulario

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
            // Bootstrap alert
            const alert = document.createElement('div');
            alert.className = "alert mt-3 " + (status >= 200 && status < 300 ? "alert-success" : "alert-danger");
            alert.innerText = data.message || "Ocurrió un error";
            document.querySelector('.card').prepend(alert);

            if (status >= 200 && status < 300) {
                setTimeout(() => {
                    window.location.href="{{ route('cursos.show', $curso) }}";
                }, 1500);
            }
        })
        .catch(error => {
            const alert = document.createElement('div');
            alert.className = "alert alert-danger mt-3";
            alert.innerText = 'No se pudo completar la solicitud';
            document.querySelector('.card').prepend(alert);
        });
    }
    </script>
@endsection
