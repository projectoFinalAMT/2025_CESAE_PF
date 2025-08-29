@extends('layouts.fe_master')
@section('css')
<link rel="stylesheet" href="{{ asset('css/cursos_home.css') }}">
<link rel="stylesheet" href="{{ asset('css/modulos_home.css') }}">
@endsection
@section('scripts')
<script src="{{ asset('js/documentos.js') }}" defer></script>
@endsection
@section('content')
<div class="content">
<div class="container my-4">
  <!-- Título -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Módulos</h2>
    <input type="text" class="form-control w-auto ms-auto" placeholder="Pesquisar Módulo..." id="pesquisa-modulos">
</div>
<!-- Botão Novo Modulo -->
<div class="mb-4">
    <button id="apagarSelecionados" class="btn btn-novo-curso" style="display:none;" data-bs-toggle="modal" data-bs-target="#confirmarEliminar">Apagar Selecionados</button>
     <button class="btn btn-novo-curso" data-bs-toggle="modal" data-bs-target="#novoModuloModal">+ Novo Módulo</button>
</div>

<!-- Modal Novo Módulo - Apenas visualização -->
<div class="modal fade" id="novoModuloModal" tabindex="-1" aria-labelledby="novoModuloModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="col-12 col-md-8">
            <h5 class="modal-title" id="novoModuloModalLabel">Adicionar novo Módulo</h5>
            <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
        </div>
        <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <form>
          <!-- Nome do módulo e dropdown de cursos -->
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="nome" class="form-label">Nome do Módulo*</label>
              <input type="text" class="form-control" id="nome" name="nome">
            </div>
            <div class="col-md-6">
              <label class="form-label">Cursos*</label>
                <div class="dropdown">
                    <button id="btn-selecao-curso" class="btn dropdown-toggle w-100" type="button" id="dropdownCursos" data-bs-toggle="dropdown" aria-expanded="false">
                    Selecionar Cursos
                    </button>
                    <ul class="dropdown-menu w-100 p-2" aria-labelledby="dropdownCursos" style="max-height:105px; overflow-y:auto;">
                        <li>
                            <div class="form-check d-flex justify-content-between align-items-center">
                                <label class="form-check-label" for="curso1">Desenvolvimento Web</label>
                                <input class="form-check-input ms-auto" type="checkbox" value="1" id="curso1">
                            </div>
                        </li>
                        <li>
                            <div class="form-check d-flex justify-content-between align-items-center">
                            <label class="form-check-label" for="curso2">Banco de Dados</label>
                            <input class="form-check-input" type="checkbox" value="2" id="curso2">
                            </div>
                        </li>
                        <li>
                            <div class="form-check d-flex justify-content-between align-items-center">
                            <label class="form-check-label" for="curso3">Inteligência Artificial</label>
                            <input class="form-check-input" type="checkbox" value="3" id="curso3">
                            </div>
                        </li>
                        <li>
                            <div class="form-check d-flex justify-content-between align-items-center">
                            <label class="form-check-label" for="curso4">Software Developer</label>
                            <input class="form-check-input" type="checkbox" value="4" id="curso4">
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

          <!-- Total de horas -->
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="total_horas" class="form-label">Total horas*</label>
              <input type="number" step="0.01" class="form-control" id="total_horas" name="total_horas">
            </div>
          </div>

          <!-- Descrição e botão adicionar documentos -->
          <div class="row g-3 mb-3 justify-content-between">
            <div class="col-md-6">
              <label for="descricao" class="form-label">Descrição</label>
              <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
            </div>
            <div class="col-md-4 d-flex flex-column gap-2 justify-content-center btn-adicionar-modulo">
              <button type="button" class="btn btn-novo-curso"><i class="bi bi-file-earmark-text-fill"></i> Adicionar Documentos</button>
            </div>
          </div>

          <!-- Botão gravar módulo -->
          <div class="text-center">
            <button type="button" class="btn btn-novo-curso">Gravar Módulo <i class="bi bi-check-lg text-success"></i></button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal Ver Detalhes -->
<div class="modal fade" id="verDetalhesModal" tabindex="-1" aria-labelledby="verDetalhesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Cabeçalho -->
      <div class="modal-header">
        <div class="col-12 col-md-8">
          <h5 class="modal-title" id="verDetalhesModalLabel">Detalhes do Módulo</h5>
        </div>
        <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>

      <!-- Corpo -->
      <div class="modal-body">
        <form>
          <!-- Nome do módulo e Cursos -->
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Nome do Módulo*</label>
              <input type="text" class="form-control" value="React Básico" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">Cursos*</label>
                <div class="dropdown">
                    <button id="btn-selecao-curso" class="btn dropdown-toggle w-100" type="button" id="dropdownCursos" data-bs-toggle="dropdown" aria-expanded="false">
                    Cursos com esse Módulo
                    </button>
                    <ul class="dropdown-menu w-100 p-2" aria-labelledby="dropdownCursos" style="max-height:105px; overflow-y:auto;">
                        <li>
                            <div class="form-check d-flex justify-content-between align-items-center">
                                <label class="form-check-label" for="curso1">Desenvolvimento Web</label>
                                <input class="form-check-input ms-auto" type="checkbox" value="1" id="curso1">
                            </div>
                        </li>
                        <li>
                            <div class="form-check d-flex justify-content-between align-items-center">
                            <label class="form-check-label" for="curso2">Banco de Dados</label>
                            <input class="form-check-input" type="checkbox" value="2" id="curso2">
                            </div>
                        </li>
                        <li>
                            <div class="form-check d-flex justify-content-between align-items-center">
                            <label class="form-check-label" for="curso3">Inteligência Artificial</label>
                            <input class="form-check-input" type="checkbox" value="3" id="curso3">
                            </div>
                        </li>
                        <li>
                            <div class="form-check d-flex justify-content-between align-items-center">
                            <label class="form-check-label" for="curso4">Software Developer</label>
                            <input class="form-check-input" type="checkbox" value="4" id="curso4">
                            </div>
                        </li>
                    </ul>
              </div>
            </div>
          </div>

          <!-- Total horas -->
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Total horas*</label>
              <input type="number" class="form-control" value="120" readonly>
            </div>
          </div>

          <!-- Descrição e documento -->
          <div class="row g-3 mb-3 justify-content-between">
            <div class="col-md-6">
              <label class="form-label">Descrição</label>
              <textarea class="form-control" rows="3" readonly>Este é um módulo de exemplo.</textarea>
            </div>
            <div class="col-md-4 d-flex flex-column gap-2 justify-content-center btn-adicionar-modulo">
              <button type="button" class="btn btn-novo-curso"><i class="bi bi-file-earmark-text-fill"></i> Ver Documentos</button>
            </div>
          </div>
          <div class="text-center">
            <button type="button" class="btn btn-novo-curso" data-bs-target="#editarModuloModal" data-bs-toggle="modal" data-bs-dismiss="modal">
              <i class="bi bi-pencil-fill"></i> Editar Módulo
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal Editar Módulo -->
<div class="modal fade" id="editarModuloModal" tabindex="-1" aria-labelledby="editarModuloModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Cabeçalho -->
      <div class="modal-header">
        <div class="col-12 col-md-8">
          <h5 class="modal-title" id="editarModuloModalLabel">Editar Módulo</h5>
          <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
        </div>
        <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>

      <!-- Corpo -->
      <div class="modal-body">
        <form>
          <!-- Nome do módulo e Cursos -->
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Nome do Módulo*</label>
              <input type="text" class="form-control" value="React Básico">
            </div>
            <div class="col-md-6">
              <label class="form-label">Cursos*</label>
                <div class="dropdown">
                    <button id="btn-selecao-curso" class="btn dropdown-toggle w-100" type="button" id="dropdownCursos" data-bs-toggle="dropdown" aria-expanded="false">
                    Selecionar Cursos
                    </button>
                    <ul class="dropdown-menu w-100 p-2" aria-labelledby="dropdownCursos" style="max-height:105px; overflow-y:auto;">
                        <li>
                            <div class="form-check d-flex justify-content-between align-items-center">
                                <label class="form-check-label" for="curso1">Desenvolvimento Web</label>
                                <input class="form-check-input ms-auto" type="checkbox" value="1" id="curso1">
                            </div>
                        </li>
                        <li>
                            <div class="form-check d-flex justify-content-between align-items-center">
                            <label class="form-check-label" for="curso2">Banco de Dados</label>
                            <input class="form-check-input" type="checkbox" value="2" id="curso2">
                            </div>
                        </li>
                        <li>
                            <div class="form-check d-flex justify-content-between align-items-center">
                            <label class="form-check-label" for="curso3">Inteligência Artificial</label>
                            <input class="form-check-input" type="checkbox" value="3" id="curso3">
                            </div>
                        </li>
                        <li>
                            <div class="form-check d-flex justify-content-between align-items-center">
                            <label class="form-check-label" for="curso4">Software Developer</label>
                            <input class="form-check-input" type="checkbox" value="4" id="curso4">
                            </div>
                        </li>
                    </ul>
              </div>
            </div>
          </div>

          <!-- Total horas -->
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Total horas*</label>
              <input type="number" class="form-control" value="120">
            </div>
          </div>

          <!-- Descrição e documento -->
          <div class="row g-3 mb-3 justify-content-between">
            <div class="col-md-6">
              <label class="form-label">Descrição</label>
              <textarea class="form-control" rows="3">Este é um módulo de exemplo.</textarea>
            </div>
            <div class="col-md-4 d-flex flex-column gap-2 justify-content-center btn-adicionar-modulo">
              <button type="button" class="btn btn-novo-curso"><i class="bi bi-file-earmark-text-fill"></i> Ver Documentos</button>
            </div>
          </div>
          <div class="text-center">
             <button type="submit" class="btn btn-novo-curso">
              Gravar Alterações <i class="bi bi-check-lg text-success"></i>
            </button>
            <button type="button" class="btn btn-novo-curso" data-bs-toggle="modal" data-bs-target="#confirmarEliminar">
              Eliminar Módulo <i class="bi bi-x-lg text-danger"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal de confirmação -->
<div class="modal fade" id="confirmarEliminar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar eliminação</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body text-center">
        <p>Tem certeza que deseja eliminar este Módulo?</p>
      </div>
      <div class="modal-footer">
        <a href="{{ route('modulos') }}" type="button" class="btn btn-novo-curso">Cancelar <i class="bi bi-check-lg text-success"></i></a>
        <button type="submit" class="btn btn-novo-curso">Eliminar  <i class="bi bi-x-lg text-danger"></i></button>
      </div>
    </div>
  </div>
</div>



  <!-- Grid de cursos -->
  <div class="row g-4">
    <!-- Card 1 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card card-cursos">
        <div class="card-body">
            <div class="row d-flex justify-content-between" >
                <div class="col-12 col-md-10">
                    <h5 class="card-title">Intrudução ao React</h5>
                    <h6 class="card-subtitle fw-light mb-4">CESAE</h6>
                </div>
                <div class="col-12 col-md-2 d-flex align-items-center justify-content-end">
                    <div class="form-check position-absolute top-0 end-0 m-2">
                        <input class="form-check-input" type="checkbox" value="" id="selecionarModulo1">
                        <label class="form-check-label" for="selecionarModulo1"></label>
                    </div>
                </div>
            </div>
                <p class="card-text fw-light">Descrição curta do Módulo...</p>
            <div class="d-flex justify-content-between px-3">
               <span class="card-text"><i class="bi bi-file-earmark-text-fill"></i>  Documentos</span>
               <span class="card-text"><i class="bi bi-clock"></i>  20h</span>
            </div>
          <div class="d-flex justify-content-between mt-4">
            <button class="btn btn-sm ms-auto btn-novo-curso" data-bs-toggle="modal" data-bs-target="#verDetalhesModal">Ver detalhes</button>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection

