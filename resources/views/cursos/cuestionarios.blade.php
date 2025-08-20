@extends('layouts.plantilla')
@section('title','cursos cuestionarios')
@section('content')
    <h1>En este cuestionario podras crear preguntas para el curso: {{$curso->name}}</h1>
    <form action="{{ route('preguntas.store', $curso) }}" id="Cuestionario" method="POST">
    @csrf

    <label>Título del cuestionario:
    <br>
        <input type="text" name="titulo" value="{{ old('titulo', $curso->cuestionario->titulo ?? '') }}" required>
    </label>
    <br>
    <br>
    <label>Pregunta:
        <br>
        <textarea name="preguntas" rows="5" required></textarea>
    </label>
    <br>

    <button type="submit">Guardar pregunta</button>
</form>

<script>
document.getElementById('Cuestionario').addEventListener('submit', function(e) {
    e.preventDefault(); // Evitamos el envío del formulario

    // Obtener el botón del formulario
    const submitButton = this.querySelector('button[type="submit"]');
    submitButton.disabled = true; 

    // Conversión del form para enviarlo en la petición
    const formData = new FormData(this);
    const token = formData.get('_token');
    
    fetch(this.action, {
        method: this.method, //Utiliza el método del form
        headers: {
            'X-CSRF-TOKEN': token //Envía el token único de la sesión
        },
        body: formData // Pasa los datos del form al request
    })
    .then(response => {
        const status = response.status;
        return response.json().then(data => ({ status, data }));
    })
    .then(({ status, data }) => {
        alert(data.message);

        if (status >= 200 && status < 300) {
            window.location.href = "{{ route('cursos.show',$curso) }}";
        }
    })
    .catch(error => {
        alert('No se pudo completar la solicitud');
        console.error(error);
    })
    .finally(() => {
        submitButton.disabled = false;
    });
});
</script>

@endsection