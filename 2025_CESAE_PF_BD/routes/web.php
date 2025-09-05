<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homeController;
use App\Http\Controllers\cursoController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AlunosController;
use App\Http\Controllers\moduloController;
use App\Http\Controllers\financasController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\documentoController;
use App\Http\Controllers\CursoModuloController;
use App\Http\Controllers\instituicaoController;
use App\Http\Controllers\loginController;

// Route::get('/home', function () {
//     return view('welcome');
// });


// Dashboard
Route::get('/dashboard', [homeController::class, 'index'])->name('casa');

//alunos
Route::get('/alunos', [AlunosController::class, 'index'])->name('alunos_view');
Route::post('/alunoadicionar', [AlunosController::class, 'store'])->name('alunos.store');
// Endpoints AJAX para selects dependentes
Route::get('/instituicoes/{id}/cursos', [CursoController::class, 'byInstituicao']);
Route::get('/cursos/{id}/modulos', [ModuloController::class, 'byCurso']);
//. alunos


// Cursos
Route::get('/cursos', [cursoController::class, 'index'])->name('cursos');
Route::post('/cursos', [cursoController::class, 'store'])->name('curso.store');
Route::post('/cursos/delete', [cursoController::class, 'deletar'])->name('curso.deletar');
Route::put('/cursos/{id}/update', [cursoController::class, 'update'])->name('curso.update');
Route::get('/cursos/buscar', [cursoController::class, 'buscar'])->name('cursos.buscar');


//Modulos
Route::get('/modulos', [moduloController::class, 'index'])->name('modulos');
Route::post('/modulos', [moduloController::class, 'store'])->name('modulo.store');
Route::post('/modulos/delete', [moduloController::class, 'deletar'])->name('modulo.deletar');
Route::put('/modulos/{id}/update', [moduloController::class, 'update'])->name('modulo.update');
Route::get('/modulos/buscar', [moduloController::class, 'buscar'])->name(' modulo.buscar');

//Eliminar Modulo/Curso
Route::post('/curso-modulo/remover', [CursoModuloController::class, 'removerAssociacao'])->name('curso-modulo.remover');


//Documentos
Route::get('/documentos', [documentoController::class, 'index'])->name('documentos');
Route::post('/documentos', [documentoController::class, 'store'])->name('documento.store');
Route::post('/documentos/delete', [documentoController::class, 'deletar'])->name('documento.deletar');
Route::put('/documento/{id}/update', [documentoController::class, 'update'])->name('documento.update');
Route::get('/documento/buscar', [documentoController::class, 'buscar'])->name(' documento.buscar');


// Finanças
Route::get('/financas', [financasController::class, 'index'])->name('financas');
Route::post('/financas', [financasController::class, 'novaFatura'])->name('novaFatura_route');


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
    //modulos por curso para o calendario
Route::get('/cursos/{curso}/modulos', [moduloController::class, 'byCurso'])
->name('cursos.modulos');
// Página do calendário (HTML)
Route::get('/calendar', [ScheduleController::class, 'index'])->name('calendarioBladeView');
//download eventos calendario
Route::get('/events/export', [EventController::class, 'exportExcel'])->name('events.export');



// Login
Route::get('/login', [loginController::class, 'login'])->name('loginRoute');


