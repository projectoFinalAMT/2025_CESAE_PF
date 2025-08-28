<?php

use App\Http\Controllers\cursoController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\moduloController;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return view('welcome');
});

Route::get('/home', [homeController::class, 'index'])->name('casa');


// Cursos
Route::get('/cursos', [cursoController::class, 'index'])->name('cursos');

//Modulos
Route::get('/modulos', [moduloController::class, 'index'])->name('modulos');

