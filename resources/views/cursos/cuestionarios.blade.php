@extends('layouts.plantilla')
@section('title','Cuestionarios')

@section('content')
    <h1 class="h4 mb-4">
        Crear cuestionario para el curso: 
        <span class="text-primary">{{ $curso->name }}</span>
    </h1>

    <form action="{{ route('preguntas.store', $curso) }}" id="Cuestionario" method="POST" class="needs-validation" novalidate>
        @csrf

        {{-- Título del cuestionario --}}
        <div class="mb-3">
            <label for="titulo" class="form-label">Título del cuestionario</label>
            <input type="text" 
                   name="titulo" 
                   id="titulo" 
                   class="form-control @error('titulo') is-invalid @enderror"
                   value="{{ old('titulo', $curso->cuestionario->titulo ?? '') }}" 
                   required>
            @error('titulo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Pregunta --}}
        <div class="mb-3">
            <label for="preguntas" class="form-label">Pregunta</label>
            <textarea name="preguntas" 
                      id="preguntas" 
                      rows="4" 
                      class="form-control @error('preguntas') is-invalid @enderror"
                      required></textarea>
            @error('preguntas')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Botones --}}
        <div class="d-flex gap-2">
            <button type="submit" id="submitBtn" class="btn btn-primary">
                <span id="btnText">Guardar Pregunta</span>
                <span id="btnLoader" class="spinner-border spinner-border-sm ms-2" style="display:none;"></span>
            </button>

            <a href="{{ route('cursos.show', $curso) }}" class="btn btn-secondary">
                Cancelar
            </a>
        </div>
    </form>

    <script>
        document.getElementById('Cuestionario').addEventListener('submit', function(e) {
            e.preventDefault();

            const submitButton = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnLoader = document.getElementById('btnLoader');

            submitButton.disabled = true;
            btnText.style.display = 'none';
            btnLoader.style.display = 'inline-block';

            const formData = new FormData(this);
            const token = formData.get('_token');

            fetch(this.action, {
                method: this.method,
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
                // Bootstrap alert dinámico
                const alert = document.createElement('div');
                alert.className = "alert mt-3 " + (status >= 200 && status < 300 ? "alert-success" : "alert-danger");
                alert.innerText = data.message || "Ocurrió un error";
                document.querySelector('.section-body').prepend(alert);

                if (status >= 200 && status < 300) {
                    setTimeout(() => {
                        window.location.href = "{{ route('cursos.show',$curso) }}";
                    }, 1500);
                }
            })
            .catch(error => {
                console.error(error);
                const alert = document.createElement('div');
                alert.className = "alert alert-danger mt-3";
                alert.innerText = 'No se pudo completar la solicitud';
                document.querySelector('.section-body').prepend(alert);
            })
            .finally(() => {
                submitButton.disabled = false;
                btnText.style.display = 'inline';
                btnLoader.style.display = 'none';
            });
        });
    </script>
@endsection
