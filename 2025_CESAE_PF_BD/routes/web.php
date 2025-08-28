<?php

use App\Http\Controllers\cursoController;
use App\Http\Controllers\homeController;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return view('welcome');
});

Route::get('/home', [homeController::class, 'index'])->name('casa');


// Cursos
Route::get('/cursos', [cursoController::class, 'index'])->name('cursos');
Route::get('/cursos_adicionar', [cursoController::class, 'curso_adicionar'])->name('cursos_adicionar');

