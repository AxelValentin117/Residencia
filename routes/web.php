<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CursoController;

Route::get('/', HomeController::class);

Route::get('asignaturas/{id}cuestionarios',[CursoController::class, 'cuestionarios'])->name('cursos.cuestionarios');

Route::resource('asignaturas', CursoController::class)->parameters(['asignaturas'=>'curso'])->names('cursos');