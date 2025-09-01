<?php

use App\Http\Controllers\cursoController;
use App\Http\Controllers\documentoController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\instituicaoController;
use App\Http\Controllers\moduloController;
use App\Http\Controllers\financasController;
use Illuminate\Support\Facades\Route;

// Route::get('/home', function () {
//     return view('welcome');
// });


// Dashboard
Route::get('/dashboard', [homeController::class, 'index'])->name('casa');


// Cursos
Route::get('/cursos', [cursoController::class, 'index'])->name('cursos');
Route::post('/cursos', [cursoController::class, 'store'])->name('curso.store');
Route::post('/curso/delete', [cursoController::class, 'deletar'])->name('curso.deletar');


//Modulos
Route::get('/modulos', [moduloController::class, 'index'])->name('modulos');

//Documentos
Route::get('/documentos', [documentoController::class, 'index'])->name('documentos');


// Finanças
Route::get('/financas', [financasController::class, 'index'])->name('financas');
Route::get('/financas_adicionar', [financasController::class, 'financas_adicionar'])->name('financas_adicionar');


// Instituicoes
Route::get('/instituicoes', [instituicaoController::class, 'index'])->name('instituicoes');
Route::post('/instituicoes', [InstituicaoController::class, 'store'])->name('instituicoes.store');
Route::post('/instituicoes/delete', [instituicaoController::class, 'deletar'])->name('instituicoes.deletar');
Route::put('/instituicoes/{id}/update', [instituicaoController::class, 'update'])->name('instituicoes.update');

