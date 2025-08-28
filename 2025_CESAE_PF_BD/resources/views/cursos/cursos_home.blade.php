@extends('layouts.fe_master')
@section('css')
<link rel="stylesheet" href="{{ asset('css/cursos_home.css') }}">
@endsection
@section('content')
<div class="content">
    <div class="container my-4">
  <!-- Título -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Cursos</h2>
    <input type="text" class="form-control  w-auto ms-auto" placeholder="Pesquisar Curso..." id="pesquisa-cursos">
    {{-- ms-auto → margem à esquerda automática, empurra o input para o final da linha.
    w-auto → limita a largura da barra de pesquisa, não ocupando todo o espaço. --}}
</div>
<!-- Botão Novo Curso -->
<div class="mb-4">
     <a href="{{ route('cursos_adicionar') }}" class="btn" id="btn-novo-curso">+ Novo Curso</a></button>
</div>
  <!-- Grid de cursos -->
  <div class="row g-4">
    <!-- Card 1 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card card-cursos">
        <div class="card-body">
            <div class="row d-flex justify-content-between" >
                <div class="col-12 col-md-8">
                <h5 class="card-title">Desenvolvimento Web</h5>
                <h6 class="card-subtitle fw-light mb-4">CESAE</h6>
                </div>
                <div class="col-12 col-md-4 d-flex align-items-center">
                    <span class="status ativo position-absolute top-0 end-0 m-3" id="btn-novo-curso">ativo</span>
                    {{-- <span class="status inativo position-absolute top-0 end-0 m-3" id="btn-novo-curso">inativo</span> --}}
                </div>
            </div>
                <p class="card-text fw-light">Descrição curta do curso...</p>
            <div class="d-flex justify-content-between px-3">
               <span class="card-text"><i class="bi bi-journal-bookmark-fill"></i>Modulos</span>
               <span class="card-text"><i class="bi bi-clock"></i>120h</span>
               <span class="card-text"><i class="bi bi-people-fill"></i>Alunos</span>
            </div>
          <div class="d-flex justify-content-between mt-4">
            <button class="btn btn-sm ms-auto" id="btn-novo-curso">Ver detalhes</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">JavaScript Avançado</h5>
          <p class="card-text">Descrição curta do curso...</p>
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Python</h5>
          <p class="card-text">Descrição curta do curso...</p>
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>
     <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Python</h5>
          <p class="card-text">Descrição curta do curso...</p>
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>
     <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Python</h5>
          <p class="card-text">Descrição curta do curso...</p>
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>
     <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Python</h5>
          <p class="card-text">Descrição curta do curso...</p>
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>
     <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Python</h5>
          <p class="card-text">Descrição curta do curso...</p>
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>
     <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Python</h5>
          <p class="card-text">Descrição curta do curso...</p>
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>
     <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Python</h5>
          <p class="card-text">Descrição curta do curso...</p>
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>
     <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Python</h5>
          <p class="card-text">Descrição curta do curso...</p>
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>
     <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Python</h5>
          <p class="card-text">Descrição curta do curso...</p>
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>
     <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Python</h5>
          <p class="card-text">Descrição curta do curso...</p>
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>
     <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Python</h5>
          <h6 class="card-subtitle">Cesae</h6>
          <p class="card-text">Descrição curta do curso...</p>

          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-primary">Ver mais</button>
            <button class="btn btn-sm btn-outline-secondary">Editar</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

{{-- <div class="container my-4">
    <!-- Linha 1: Título e barra de pesquisa -->
    <div class="d-flex align-items-center mb-3">
        <h2 class="fw-bold">Cursos</h2>
        <input type="text" class="form-control w-auto ms-auto" placeholder="Pesquisar Curso..." id="pesquisa-cursos" style="width: 200px;">
    </div>

    <!-- Linha 2: Botão Novo Curso -->
    <div class="mb-4">
        <a href="{{ route('cursos.create') }}" class="btn btn-primary">+ Novo Curso</a>
    </div>

   <!-- Linha 3: Grid de cursos -->
@if($cursos->count() > 0)
    <div class="row g-4">
        @foreach($cursos as $curso)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card card-cursos shadow-sm h-100 position-relative">

                    <!-- Status ativo/inativo no canto superior direito -->
                    <span class="status {{ $curso->ativo ? 'ativo' : 'inativo' }} position-absolute top-0 end-0 m-3">
                        {{ $curso->ativo ? 'ativo' : 'inativo' }}
                    </span>

                    <div class="card-body">
                        <h5 class="card-title">{{ $curso->nome }}</h5>

                        @if($curso->subtitulo)
                            <h6 class="card-subtitle fw-light mb-4">{{ $curso->subtitulo }}</h6>
                        @endif

                        <p class="card-text fw-light">{{ $curso->descricao }}</p>

                        @if($curso->modulos || $curso->horas || $curso->alunos)
                            <div class="d-flex justify-content-between px-3">
                                <span class="card-text"><i class="bi bi-journal-bookmark-fill"></i> {{ $curso->modulos_count ?? 0 }}</span>
                                <span class="card-text"><i class="bi bi-clock"></i> {{ $curso->horas ?? '-' }}</span>
                                <span class="card-text"><i class="bi bi-people-fill"></i> {{ $curso->alunos_count ?? 0 }}</span>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-sm btn-outline-primary">Ver mais</a>
                            <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p class="text-muted">Nenhum curso cadastrado ainda.</p>
@endif--}}

</div>
@endsection
