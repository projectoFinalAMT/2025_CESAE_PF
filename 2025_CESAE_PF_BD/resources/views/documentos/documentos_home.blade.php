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
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <button class="btn btn-novo-curso me-2 filtro-btn active">Documentos Pessoais</button>
        <button class="btn btn-novo-curso filtro-btn">Material de Apoio</button>
    </div>
<!-- Botão Novo Documento -->
<div class="mb-4">
     <button id="apagarSelecionados" class="btn btn-novo-curso" style="display:none;" data-bs-toggle="modal" data-bs-target="#confirmarEliminar">Apagar Selecionados</button>
     <button class="btn btn-novo-curso me-2" data-bs-toggle="modal" data-bs-target="#novoDocumentoModal">+ Novo Documento</button>
</div>
</div>

<!-- Modal Novo Documento -->
@include('componentes.documento.novo-documento')


<!-- Modal de confirmação -->
@include('componentes.documento.eliminar-documento')

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

