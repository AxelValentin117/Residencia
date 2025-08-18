@extends('layouts.plantilla')
@section('title','cursos cuestionarios')
@section('content')
    <h1>En este cuestionario podras crear preguntas para el curso: {{$curso->name}}</h1>
    <form action="{{ route('preguntas.store', $curso) }}" id="cuestionario" method="POST">
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
document.getElementById('cuestionario').addEventListener('submit', function(e) {
    e.preventDefault(); // Evitamos el envío del formulario

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
        const status = response.status; //Obtiene el estado de la respuesta
        return response.json().then(data => ({ status, data })); 
    })
    .then(({ status, data }) => {
        alert(data.message); // Mostramos mensaje del backend
	
//Redirige si el status fue 2xx (OK)
        if (status >= 200 && status < 300) {
            window.location.href = "{{ route('cursos.show', $curso) }}";
        }
    })
    .catch(error => alert('No se pudo completar la solicitud')); //Error genérico
});
</script>

@endsection