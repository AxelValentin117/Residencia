@extends('layouts.plantilla')

@section('title','Crear Curso')

@section('content')
    <form action="{{route('cursos.store')}}" id="CrearCurso" method="POST">
        @csrf

   
        <div class="mb-3">
            <label for="name" class="form-label">Nombre del curso</label>
            <input type="text" 
                   name="name" 
                   id="name" 
                   class="form-control @error('name') is-invalid @enderror" 
                   value="{{old('name')}}" 
                   required>
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

    
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" 
                      id="descripcion" 
                      rows="4"  
                      class="form-control @error('descripcion') is-invalid @enderror" 
                      required>{{old('descripcion')}}</textarea>
            @error('descripcion')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

    
        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <input type="text" 
                   name="categoria" 
                   id="categoria" 
                   class="form-control @error('categoria') is-invalid @enderror" 
                   value="{{old('categoria')}}" 
                   required>
            @error('categoria')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Botón --}}
        <div class="d-grid">
            <button type="submit" id="submitBtn" class="btn btn-primary">
                <span id="btnText">Enviar Formulario</span>
                <span id="btnLoader" class="spinner-border spinner-border-sm ms-2" style="display:none;"></span>
            </button>
        </div>
    </form>

    <script>
    document.getElementById('CrearCurso').addEventListener('submit', function(e) {
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
            if (status >= 200 && status < 300) {
                const alert = document.createElement('div');
                alert.className = "alert alert-success mt-3";
                alert.innerText = data.message || 'Curso creado con éxito 🎉';
                document.querySelector('.section-body').prepend(alert);

                setTimeout(() => {
                    window.location.href = "{{ route('cursos.index') }}";
                }, 1500);
            } else if (status === 422) {
                const alert = document.createElement('div');
                alert.className = "alert alert-danger mt-3";
                alert.innerText = "Revisa los campos del formulario.";
                document.querySelector('.section-body').prepend(alert);
            } else {
                const alert = document.createElement('div');
                alert.className = "alert alert-warning mt-3";
                alert.innerText = data.message || 'Ocurrió un error inesperado';
                document.querySelector('.section-body').prepend(alert);
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
