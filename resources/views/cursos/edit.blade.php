@extends('layouts.plantilla')

@section('title','Editar Curso')

@section('content')
    <h1 class="h4 mb-4">Editar curso: <span class="text-primary">{{ $curso->name }}</span></h1>

    <form id="editarcurso" action="{{ route('cursos.update', $curso) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nombre del curso</label>
            <input type="text" 
                   name="name" 
                   id="name" 
                   class="form-control @error('name') is-invalid @enderror" 
                   value="{{ $curso->name }}" 
                   required>
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Descripción --}}
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" 
                      id="descripcion" 
                      rows="4" 
                      class="form-control @error('descripcion') is-invalid @enderror" 
                      required>{{ $curso->descripcion }}</textarea>
            @error('descripcion')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Categoría --}}
        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <input type="text" 
                   name="categoria" 
                   id="categoria" 
                   class="form-control @error('categoria') is-invalid @enderror" 
                   value="{{ $curso->categoria }}" 
                   required>
            @error('categoria')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Botón --}}
        <div class="d-grid">
            <button type="submit" id="submitBtn" class="btn btn-success">
                <span id="btnText">Actualizar Curso</span>
                <span id="btnLoader" class="spinner-border spinner-border-sm ms-2" style="display:none;"></span>
            </button>
        </div>
    </form>

    <script>
        document.getElementById('editarcurso').addEventListener('submit', function(e) {
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
                // Alert Bootstrap dinámico
                const alert = document.createElement('div');
                alert.className = "alert mt-3 " + (status >= 200 && status < 300 ? "alert-success" : "alert-danger");
                alert.innerText = data.message || "Ocurrió un error";
                document.querySelector('.section-body').prepend(alert);

                if (status >= 200 && status < 300) {
                    setTimeout(() => {
                        window.location.href = "{{ route('cursos.show', $curso) }}";
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
