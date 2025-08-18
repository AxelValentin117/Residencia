@extends('layouts.plantilla')
@section('title','cursos edit')
@section('content')
    <h1>En esta pagina podras editar un curso de esta nueva version</h1>

    <form id="editarcurso" action="{{ route('cursos.update', $curso) }}" method="POST">
        @csrf
        @method('PUT')

        <label>
            Nombre:
            <br>
            <input type="text" name="name" value="{{ $curso->name }}">
        </label>
        @error('name')
            <div style="">{{ $message }}</div>
        @enderror
        
        <br>
        <label>
            Descripción:
            <br>
            <textarea name="descripcion" rows="5">{{ $curso->descripcion }}</textarea>
        </label>
        <br>
        <label>
            Categoría:
            <br>
            <input type="text" name="categoria" value="{{ $curso->categoria }}">
        </label>
        <br><br>
        <button type="submit">Actualizar Formulario</button>
    </form>

    <script>
        document.getElementById('editarcurso').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const token = formData.get('_token');

            fetch(this.action, {
                method: 'POST',
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
                    
                    window.location.href = "{{ route('cursos.show', $curso) }}";
                }
            })
            .catch(error => {
                alert('No se pudo completar la solicitud');
                console.error(error);
            });
        });
    </script>
@endsection
