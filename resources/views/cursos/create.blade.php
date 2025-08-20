@extends('layouts.plantilla')
@section('title','cursos create')
@section('content')
    <h1>En esta pagina podras crear un curso</h1>
    <form action="{{route('cursos.store')}}"  id="CrearCurso" method="POST">
        @csrf
        <label>
            Nombre:
            <br>
            <input type="text" name="name" value="{{old('name')}}">
        </label>
        @error('name')
            <br>
            <span>{{'campo invalido'}}</span>
            <br>
        @enderror
        <br>
        <label>
            Descripcion:
            <br>
            <textarea name="descripcion" rows= "5" >{{old(' ')}}</textarea>
        </label>
        @error('descripcion')
            <br>
            <span>{{'campo invalido'}}</span>
            <br>
        @enderror
        <br>
        <label>
            Categoria:
            <br>
            <input type="text" name="categoria" value="{{old('categoria')}}">
        </label>
        @error('categoria')
            <br>
            <span>{{'campo invalido'}}</span>
            <br>
        @enderror
        <button type="submit">Enviar Formulario</button>
    </form>

    <script>
document.getElementById('CrearCurso').addEventListener('submit', function(e) {
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
            window.location.href = "{{ route('cursos.index') }}";
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