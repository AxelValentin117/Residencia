@extends('layouts.plantilla')

@section('title', 'Editar pregunta')

@section('content')
    <h1>Editar pregunta en: {{ $curso->name }}</h1>

    <form action="{{ route('preguntas.update', [$curso, $pregunta]) }}" id="editarcuestionario" method="POST">
        @csrf
        @method('PUT')

        <label for="text_pregunta">Pregunta:</label><br>
        <textarea name="text_pregunta" id="text_pregunta" rows="5" required>{{ old('text_pregunta', $pregunta->text_pregunta) }}</textarea>
        <br><br>

        <button type="submit">Actualizar pregunta</button>
    </form>

    <br>
    <a href="{{ route('preguntas.editarcuestionario', $curso) }}">Volver al cuestionario</a>

    <script>
document.getElementById('editarcuestionario').addEventListener('submit', function(e) {
    e.preventDefault(); // Evitamos el envío del formulario

    // Conversión del form para enviarlo en la petición
    const formData = new FormData(this);

    const token = formData.get('_token');
    const method = formData.get('_method');

    fetch(this.action, {
        method: method, //Utiliza el método del form
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
            window.history.back();
        }
    })
    .catch(error => alert('No se pudo completar la solicitud')); //Error genérico
});
</script>
@endsection
