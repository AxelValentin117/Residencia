@extends('layouts.plantilla')

@section('title', 'Editar pregunta')

@section('content')
    <h1 class="h4 mb-4">Editar pregunta en: <span class="text-primary">{{ $curso->name }}</span></h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('preguntas.update', [$curso, $pregunta]) }}" id="editarpregunta" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="text_pregunta" class="form-label">Pregunta</label>
                    <textarea 
                        name="text_pregunta" 
                        id="text_pregunta" 
                        rows="4" 
                        class="form-control" 
                        required>{{ old('text_pregunta', $pregunta->text_pregunta) }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Actualizar pregunta
                </button>
                <a href="{{ route('preguntas.editarcuestionario', $curso) }}" class="btn btn-secondary">
                    Volver al cuestionario
                </a>
            </form>
        </div>
    </div>

    <script>
    document.getElementById('editarpregunta').addEventListener('submit', function(e) {
        e.preventDefault(); 

        const formData = new FormData(this);
        const token = formData.get('_token');

        fetch(this.action, {
            method: 'POST', // Laravel respeta _method=PUT
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
            // Mostrar alert de Bootstrap
            const alert = document.createElement('div');
            alert.className = "alert mt-3 " + (status >= 200 && status < 300 ? "alert-success" : "alert-danger");
            alert.innerText = data.message || "Ocurrió un error";
            document.querySelector('.card-body').prepend(alert);

            if (status >= 200 && status < 300) {
                setTimeout(() => {
                    window.location.href="{{ route('preguntas.editarcuestionario', $curso) }}";
                }, 1500);
            }
        })
        .catch(error => {
            const alert = document.createElement('div');
            alert.className = "alert alert-danger mt-3";
            alert.innerText = "No se pudo completar la solicitud";
            document.querySelector('.card-body').prepend(alert);
        });
    });
    </script>
@endsection
