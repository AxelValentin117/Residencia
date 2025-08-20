<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\PreguntaController;
use Illuminate\Http\Request;

    Route::get('/', HomeController::class);

    Route::get('asignaturas/{curso}/cuestionario/editar', [PreguntaController::class, 'editarCuestionario'])->name('preguntas.editarcuestionario');
    
    Route::get('asignaturas/{curso}/cuestionario/editarpregunta', [PreguntaController::class, 'editPregunta'])->name('preguntas.editpreguntas');

    Route::get('asignaturas/{curso}/preguntas/{pregunta}/edit', [PreguntaController::class, 'edit'])->name('preguntas.edit');

    Route::put('asignaturas/{curso}/preguntas/{pregunta}', [PreguntaController::class, 'update'])->name('preguntas.update');

    Route::delete('asignaturas/{curso}/preguntas/{pregunta}', [PreguntaController::class, 'destroy'])->name('preguntas.destroy');


    Route::get('asignaturas/{curso}/cuestionarios', [CursoController::class, 'cuestionarios'])->name('cursos.cuestionarios');

    Route::post('asignaturas/{curso}/preguntas', [PreguntaController::class, 'store'])->name('preguntas.store');

    Route::resource('asignaturas', CursoController::class)->parameters(['asignaturas' => 'curso'])->names('cursos');

    Route::get('/json-prueba', function (Request $request) {
    return response()->json([
        'status' => 200, // Código de estado de la petición
        'message' => 'Artículo obtenido con éxito', // Mensaje para mostrar al usuario
        'data' => [
            'id' => 1,
            'titulo' => 'Introducción a Laravel',
            'contenido' => 'Este es un artículo de ejemplo sobre Laravel.',
            'autor' => 'Juan Pérez',
            'fecha_creacion' => '2025-08-13'
    ]]);
});

