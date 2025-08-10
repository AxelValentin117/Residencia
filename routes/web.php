<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\PreguntaController;

Route::get('/', HomeController::class);

Route::get('asignaturas/{curso}/cuestionarios', [CursoController::class, 'cuestionarios'])->name('cursos.cuestionarios');

Route::post('asignaturas/{curso}/preguntas', [PreguntaController::class, 'store'])->name('preguntas.store');

Route::resource('asignaturas', CursoController::class)
    ->parameters(['asignaturas' => 'curso'])
    ->names('cursos');

