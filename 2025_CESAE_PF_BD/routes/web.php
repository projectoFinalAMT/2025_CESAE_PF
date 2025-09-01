<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homeController;
use App\Http\Controllers\instituicaoController;
use App\Http\Controllers\cursoController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\moduloController;
use App\Http\Controllers\financasController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\documentoController;

// Route::get('/home', function () {
//     return view('welcome');
// });


// Dashboard
Route::get('/dashboard', [homeController::class, 'index'])->name('casa');



// Cursos
Route::get('/cursos', [cursoController::class, 'index'])->name('cursos');
Route::post('/cursos', [cursoController::class, 'store'])->name('curso.store');
Route::post('/cursos/delete', [cursoController::class, 'deletar'])->name('curso.deletar');
Route::put('/cursos/{id}/update', [cursoController::class, 'update'])->name('curso.update');
Route::get('/cursos/buscar', [CursoController::class, 'buscar'])->name('cursos.buscar');


//Modulos
Route::get('/modulos', [moduloController::class, 'index'])->name('modulos');
Route::post('/modulos', [moduloController::class, 'store'])->name('modulo.store');
Route::post('/modulos/delete', [moduloController::class, 'deletar'])->name('modulo.deletar');
Route::put('/modulos/{id}/update', [moduloController::class, 'update'])->name('modulo.update');
Route::get('/modulos/buscar', [moduloController::class, 'buscar'])->name(' modulo.buscar');

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
Route::get('/instituicoes/buscar', [InstituicaoController::class, 'buscar'])->name('instituicoes.buscar');

//Calendario
//O middleware auth vai ser necessario para cada utilizador ver o seu calendario
// Route::middleware('auth')->group(function () {

    // Retorna todos os eventos do formador logado
    Route::get('/events', [EventController::class, 'index']);
    // Cria um novo evento
    Route::post('/events', [EventController::class, 'store']);
    // Atualiza um evento existente
    Route::put('/events/{event}', [EventController::class, 'update']);
    // Deleta um evento
    Route::delete('/events/{event}', [EventController::class, 'destroy']);
    // ver calendario
   // Página do calendário (HTML)
Route::get('/calendar', [ScheduleController::class, 'index'])->name('calendarioBladeView');


// });
