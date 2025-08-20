@extends('layouts.plantilla')

@section('title','Cursos')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="fw-bold">📚 Lista de Cursos</h1>
        <a href="{{ route('cursos.create') }}" class="btn btn-primary">➕ Crear curso</a>
    </div>

    @if($cursos->count() > 0)
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach ($cursos as $curso)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('cursos.show', $curso->id) }}" class="text-decoration-none fw-semibold">
                                {{ $curso->name }}
                            </a>
                            <span class="badge bg-secondary">ID: {{ $curso->id }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="mt-3">
            {{ $cursos->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="alert alert-warning mt-3">No hay cursos registrados aún.</div>
    @endif

</div>
@endsection
