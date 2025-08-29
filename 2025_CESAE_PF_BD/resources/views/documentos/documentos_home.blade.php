@extends('layouts.fe_master')
@section('css')
<link rel="stylesheet" href="{{ asset('css/cursos_home.css') }}">
<link rel="stylesheet" href="{{ asset('css/modulos_home.css') }}">
<link rel="stylesheet" href="{{ asset('css/documentos_home.css') }}">
@endsection
@section('scripts')
<script src="{{ asset('js/documentos.js') }}" defer></script>
@endsection
@section('content')
<div class="content">
<div class="container my-4">
  <!-- Título -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Documentos</h2>
    <div class="d-flex align-items-center gap-2">
        <input type="text" class="form-control w-auto" placeholder="Pesquisar Documento..." id="pesquisa-documentos">
    </div>
</div>
<!-- Botão Novo Documento -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <button class="btn btn-novo-curso me-2 filtro-btn active">Documentos Pessoais</button>
        <button class="btn btn-novo-curso filtro-btn">Material de Apoio</button>
    </div>

<div class="mb-4">
     <button id="apagarSelecionados" class="btn btn-novo-curso" style="display:none;" data-bs-toggle="modal" data-bs-target="#confirmarEliminar">Apagar Selecionados</button>
     <button class="btn btn-novo-curso me-2" data-bs-toggle="modal" data-bs-target="#novoDocumentoModal">+ Novo Documento</button>
</div>
</div>

<!-- Modal Novo Módulo - Apenas visualização -->
<div class="modal fade" id="novoDocumentoModal" tabindex="-1" aria-labelledby="novoDocumentoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="col-12 col-md-8">
            <h5 class="modal-title" id="novoDocumentoModalLabel">Adicionar novo Documento</h5>
            <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
        </div>
        <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <form id="form-documento">

  <!-- Botões de seleção -->
  <div class="mb-4">
    <button type="button" class="btn btn-novo-curso me-2 tipo-btn" data-tipo="pessoal">Documento Pessoal</button>
    <button type="button" class="btn btn-novo-curso tipo-btn" data-tipo="apoio">Material de Apoio</button>
  </div>

  <!-- Formulário Documento Pessoal -->
<div id="form-pessoal" class="form-tipo" style="display:block;">
  <div class="row g-3 mb-3">
    <div class="col-md-5">
      <label for="nome_pessoal" class="form-label">Nome do Documento*</label>
      <input type="text" class="form-control" id="nome_pessoal" name="nome_pessoal">
    </div>

    <div class="col-md-4">
      <label for="validade" class="form-label">Data de Validade*</label>
      <input type="date" class="form-control" id="validade" name="validade">
    </div>

    <div class="col-md-3 d-flex align-items-center">
      <div class="form-check mt-4">
        <input class="form-check-input" type="checkbox" id="vitalicio">
        <label class="form-check-label" for="vitalicio">Vitalício</label>
      </div>
    </div>
  </div>

  <!-- Tipo de Documento e Upload -->
  <div class="row g-3 mb-3 align-items-end">
    <div class="col-md-8">
      <label for="arquivo_documento" class="form-label">Selecionar Documento*</label>
      <input
        type="file"
        class="form-control"
        id="arquivo_documento"
        name="arquivo_documento">
    </div>
    <div class="col-md-4">
      <label for="tipo_documento" class="form-label">Formato do Documento*</label>
      <select class="form-select" id="tipo_documento" name="tipo_documento">
        <option value="" selected>Selecione o formato</option>
        <option value="pdf">PDF</option>
        <option value="docx">DOCX</option>
        <option value="jpg">JPG</option>
        <option value="png">PNG</option>
      </select>
    </div>
    <small class="text-muted">O arquivo deve corresponder ao formato selecionado.</small>
  </div>
</div>

  <!-- Formulário Material de Apoio -->
  <div id="form-apoio" class="form-tipo" style="display:block;">
    <div class="row g-3 mb-3">
      <div class="col-md-6">
        <label for="nome_apoio" class="form-label">Nome do Material*</label>
        <input type="text" class="form-control" id="nome_apoio" name="nome_apoio">
      </div>
      <div class="col-md-6">
              <label class="form-label">Módulos</label>
                <div class="dropdown">
                    <button id="btn-selecao-curso" class="btn dropdown-toggle w-100" type="button" id="dropdownCursos" data-bs-toggle="dropdown" aria-expanded="false">
                    Selecionar Módulos
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

  <!-- Tipo de Documento e Upload -->
  <div class="row g-3 mb-3 align-items-end">
    <div class="col-md-8">
      <label for="arquivo_documento" class="form-label">Selecionar Documento*</label>
      <input
        type="file"
        class="form-control"
        id="arquivo_documento"
        name="arquivo_documento">
    </div>
    <div class="col-md-4">
      <label for="tipo_documento" class="form-label">Formato do Documento*</label>
      <select class="form-select" id="tipo_documento" name="tipo_documento">
        <option value="" selected>Selecione o formato</option>
        <option value="pdf">PDF</option>
        <option value="docx">DOCX</option>
        <option value="jpg">JPG</option>
        <option value="png">PNG</option>
      </select>
    </div>
    <small class="text-muted">O arquivo deve corresponder ao formato selecionado.</small>
  </div>
</div>


  <!-- Botão gravar -->
  <div class="text-center mt-5">
    <button type="submit" class="btn btn-novo-curso"><i class=" bi bi-check-lg text-success"></i> Gravar Documento</button>
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
        <p>Tem certeza que deseja eliminar este/s Documento/s?</p>
      </div>
      <div class="modal-footer">
        <a href="{{ route('documentos') }}" type="button" class="btn btn-novo-curso">Cancelar <i class="bi bi-check-lg text-success"></i></a>
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
                    <h5 class="card-title">Certificado de Formador</h5>
                    <h6 class="card-subtitle fw-light mb-4">PDF</h6>
                </div>
                <div class="col-12 col-md-2 d-flex align-items-center justify-content-end">
                    <div class="form-check position-absolute top-0 end-0 m-2">
                        <input class="form-check-input" type="checkbox" value="" id="selecionarModulo1">
                        <label class="form-check-label" for="selecionarModulo1"></label>
                    </div>
                </div>
            </div>
                <p class="card-text fw-light">Descrição curta do Documento...</p>
            <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex col-12 col-md-8">
               <span class="card-text"><i class="bi bi-clock"></i>  Expira em 12/02/2026</span>
            </div>
            <div class="col-12 col-md-4 d-flex align-items-center">
                    {{-- <span class="status ativo m-3 btn-novo-curso">Válido</span> --}}
                    <span class="status expirar m-2 btn-novo-curso">A expirar</span>
                    {{-- <span class="status inativo m-2 btn-novo-curso">Vencido</span> --}}
            </div>
            </div>
          <div class="d-flex justify-content-between mt-4">
            <a href="" class="btn btn-sm btn-novo-curso" target="_blank"><i class="bi bi-eye-fill"></i>  Preview</a>
            <a href="" class="btn btn-sm btn-novo-curso" download><i class="bi bi-download"></i>  Donwload</a>
            <button class="btn btn-sm btn-novo-curso" data-bs-toggle="modal" data-bs-target="#confirmarEliminar"><i class="bi bi-trash-fill"></i> Apagar</button>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection

