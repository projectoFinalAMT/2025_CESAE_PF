<?php

use App\Http\Controllers\cursoController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\financasController;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return view('welcome');
});

Route::get('/home', [homeController::class, 'index'])->name('casa');

// Cursos
Route::get('/cursos', [cursoController::class, 'index'])->name('cursos');
Route::get('/cursos_adicionar', [cursoController::class, 'curso_adicionar'])->name('cursos_adicionar');

// Finanças
Route::get('/financas', [financasController::class, 'index'])->name('financas');
Route::get('/financas_adicionar', [financasController::class, 'financas_adicionar'])->name('financas_adicionar');

