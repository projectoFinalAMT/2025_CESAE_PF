<?php

use App\Http\Controllers\AlunoModuloController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\cursoController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\AlunosController;
use App\Http\Controllers\moduloController;
use App\Http\Controllers\financasController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\documentoController;
use App\Http\Controllers\CursoModuloController;
use App\Http\Controllers\instituicaoController;
use App\Http\Controllers\RecebimentoController;
use App\Http\Controllers\DocumentoModuloController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;



Route::post('/user', [UserController::class, 'store'])->name('user.store');
Route::put('/users/{user}', [UserController::class, 'update'])->name('user.update');

Route::post('/logout', function () { Auth::logout();
    return redirect('/login'); })->name('logout');



// AUTH ROTAS
 Route::middleware('auth')->group(function () {



// Dashboard
Route::get('/home', [homeController::class, 'index'])->name('casa');

//alunos
Route::get('/alunos', [AlunosController::class, 'index'])->name('alunos_view');
// Route::get('/alunoinfo', [AlunosController::class, 'alunoinfo'])->name('alunos_info');
Route::post('/alunoadicionar', [AlunosController::class, 'store'])->name('alunos.store');

//uptade aluno
Route::put('/alunos', [AlunosController::class, 'updateAluno'])->name('alunos.update');

// Endpoints AJAX para selects dependentes
Route::get('/instituicoes/{id}/cursos', [CursoController::class, 'byInstituicao']);
Route::get('/cursos/{id}/modulos', [ModuloController::class, 'byCurso']);
Route::get('/fichaaluno',[AlunosController::class,'fichaaluno']);


Route::post('/alunos/medias', [AlunoModuloController::class, 'atualizarMedias'])
    ->name('alunos.atualizarMedias');



Route::post('/alunos/delete', [AlunosController::class, 'delete'])->name('alunos.destroy');


//. alunos


// Cursos
Route::get('/cursos', [cursoController::class, 'index'])->name('cursos');
Route::post('/cursos', [cursoController::class, 'store'])->name('curso.store');
Route::post('/cursos/delete', [cursoController::class, 'deletar'])->name('curso.deletar');
Route::put('/cursos/{id}/update', [cursoController::class, 'update'])->name('curso.update');
Route::get('/cursos/buscar', [cursoController::class, 'buscar'])->name('cursos.buscar');
Route::post('/cursos/{curso}/toggle-estado', [CursoController::class, 'toggleEstado'])->name('cursos.toggleEstado');

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
//Eliminar Modulo/Documento
Route::post('/documento-modulo/remover', [DocumentoModuloController::class, 'removerAssociacao'])->name('documento-modulo.remover');


// Finanças
Route::get('/financas', [financasController::class, 'index'])->name('financas');
Route::post('/financas', [financasController::class, 'novaFatura'])->name('novaFatura_route');
Route::put('/financas/{financa}', [financasController::class, 'update'])->name('faturaUpdate_route');
Route::delete('/financas/{financa}', [financasController::class, 'apagar'])->name('financas.apagar');




// Instituicoes
Route::get('/instituicoes', [instituicaoController::class, 'index'])->name('instituicoes');
Route::post('/instituicoes', [InstituicaoController::class, 'store'])->name('instituicoes.store');
Route::post('/instituicoes/delete', [instituicaoController::class, 'deletar'])->name('instituicoes.deletar');
Route::put('/instituicoes/{id}/update', [instituicaoController::class, 'update'])->name('instituicoes.update');
Route::get('/instituicoes/buscar', [InstituicaoController::class, 'buscar'])->name('instituicoes.buscar');



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

 }); // .AUTH ROTAS






