<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\PreguntaController;

    Route::get('/', HomeController::class);

    Route::get('asignaturas/{curso}/cuestionario/editar', [PreguntaController::class, 'editarCuestionario'])->name('preguntas.editarcuestionario');
    
    Route::get('asignaturas/{curso}/cuestionario/editarpregunta', [PreguntaController::class, 'editPregunta'])->name('preguntas.editpreguntas');

    Route::get('asignaturas/{curso}/preguntas/{pregunta}/edit', [PreguntaController::class, 'edit'])->name('preguntas.edit');

    Route::put('asignaturas/{curso}/preguntas/{pregunta}', [PreguntaController::class, 'update'])->name('preguntas.update');

    Route::delete('asignaturas/{curso}/preguntas/{pregunta}', [PreguntaController::class, 'destroy'])->name('preguntas.destroy');



    Route::get('asignaturas/{curso}/cuestionarios', [CursoController::class, 'cuestionarios'])->name('cursos.cuestionarios');

    Route::post('asignaturas/{curso}/preguntas', [PreguntaController::class, 'store'])->name('preguntas.store');

    Route::resource('asignaturas', CursoController::class)->parameters(['asignaturas' => 'curso'])->names('cursos');

