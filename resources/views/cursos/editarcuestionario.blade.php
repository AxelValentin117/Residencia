@extends('layouts.plantilla')

@section('title', 'Editar cuestionario - ' . $curso->name)

@section('content')
    <h1>Editar cuestionario: {{ $curso->name }}</h1>

    @if(session('success'))
        <div style="">{{ session('success') }}</div>
    @endif

    @if($preguntas->count())
        <ul>
            @foreach($preguntas as $pregunta)
                <li>
                    {{ $pregunta->text_pregunta }}
                    <br>
                    <a href="{{ route('preguntas.edit', [$curso, $pregunta]) }}">Editar</a>
                    <form onSubmit="BorrarCuestionario(event,this)" action="{{ route('preguntas.destroy', [$curso, $pregunta]) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Eliminar pregunta?')">Eliminar</button>
                    </form>
                </li>
            @endforeach
        </ul>
        <a href="{{ route('cursos.show', $curso) }}">Volver al cuestionario</a>
    @else
        <p>No hay preguntas aún.</p>
    @endif
    <script>
    function BorrarCuestionario(event, formulario){
    event.preventDefault(); // Evitamos el envío del formulario

    // Conversión del form para enviarlo en la petición
    const formData = new FormData(formulario);

    const token = formData.get('_token');
    const method = formData.get('_method');
    console.log(formData);

    fetch(formulario.action, {
        method: 'POST', //Utiliza el método del form
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
            window.location.href="{{ route('cursos.show', $curso) }}";
        }
    })
    .catch(error => alert('No se pudo completar la solicitud')); //Error genérico

}
</script>
@endsection
