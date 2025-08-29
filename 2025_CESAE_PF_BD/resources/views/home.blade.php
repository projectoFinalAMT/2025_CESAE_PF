@extends('layouts.fe_master')
@section('css')
<!-- Font Awesome (versão 6 mais recente no CDN) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"> <!-- css bootstrap -->
<!-- css interno -->
<link rel="stylesheet" href="{{asset ('css/dashboard_css/dashboard.css')}}">
<link rel="stylesheet" href="{{ asset('css/cursos_home.css') }}">
<script src="{{ asset('assets/bootstrap.js')}}" defer></script> <!--Script bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>











@section('content')
<div class="content">

    <div class="container my-4">

  <!-- Título -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Dashboard</h2>
    <input type="text" class="form-control  w-auto ms-auto" placeholder="Pesquisar na Dashboard..." id="pesquisa-dashboard">
    {{-- ms-auto → margem à esquerda automática, empurra o input para o final da linha.
    w-auto → limita a largura da barra de pesquisa, não ocupando todo o espaço. --}}
</div>

  <!-- Grid dos card -->
  <div class="row g-4">
    <!-- Card 1 -->
    <div class="col-12 col-md-6 col-lg-3">
      <div class="card card-info">
        <div class="card-body">
            <div class="row d-flex justify-content-between" >
                <div class="col-12 col-md-8">
                <h5 class="card-title d-flex align-items-center justify-content-start">Cursos Ativos<i class="fa-solid fa-graduation-cap"></i></h5>
                </div>
            </div>
                <p class="card-text fw-bold fs-3">0</p>
            <div class="d-flex justify-content-between px-3">
               <span class="card-text">0 novos</span>
            </div>

        </div>
      </div>
    </div>

     <!-- Card 2 -->
     <div class="col-12 col-md-6 col-lg-3">
        <div class="card card-info">
          <div class="card-body">
              <div class="row d-flex justify-content-between" >
                  <div class="col-12 col-md-8">
                  <h5 class="card-title">Total alunos<i class="fa-solid fa-user"></i></h5>
                  </div>
              </div>
                  <p class="card-text fw-bold fs-3">0</p>
              <div class="d-flex justify-content-between px-3">
                 <span class="card-text">0 novos</span>
              </div>

          </div>
        </div>
      </div>

    <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card card-info">
          <div class="card-body">
              <div class="row d-flex justify-content-between" >
                  <div class="col-12 col-md-8">
                  <h5 class="card-title">Documento<i class="fa-solid fa-file"></i></h5>
                  </div>
              </div>
                  <p class="card-text fw-bold fs-3">0</p>
              <div class="d-flex justify-content-between px-3">
                 <span class="card-text">0 a expirar em breve</span>
              </div>

          </div>
        </div>
      </div>

       <!-- Card 4 -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card card-info">
          <div class="card-body">
              <div class="row d-flex justify-content-between" >
                  <div class="col-12 col-md-8">
                  <h5 class="card-title">Aulas este mês<i class="fa-solid fa-calendar-days"></i></h5>
                  </div>
              </div>
                  <p class="card-text fw-bold fs-3">0</p>
              <div class="d-flex justify-content-between px-3">
                 <span class="card-text">0 esta semana</span>
              </div>

          </div>
        </div>
      </div>
  </div>



  <div class="container text-center ">
    <div class="row my-4">

        <!-- Full calendar -->
      <div class="col-sm-8">
<div class="container">
    <div class="card">
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>
</div>
      </div>

<!-- card filter full calendar -->
<div class="col-sm-4">
    <div id="filterBox" class="card" style="width: 18rem;">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <h5 class="card-title mb-0">Agendamentos</h5>
          <div class="dropdown">
            <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
              <i class="fa-solid fa-filter"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#">Todos</a></li>
              <li><a class="dropdown-item" href="#">Pendentes</a></li>
              <li><a class="dropdown-item" href="#">Concluídos</a></li>
            </ul>
          </div>
        </div>
        <p id="subtitle" class="card-subtitle mb-2 text-body-secondary">para hoje</p>
        <p class="card-text">Sem eventos a mostrar</p>
      </div>
    </div>
  </div>

    </div>
    </div>

<!-- quick actions -->
    <div class="row my-4 justify-content-center">
        <div id="fastAction" class="col-10">
            <h5 class="title">Ações rápidas</h5>
            <p id="subtitle">Acesso rápido às funcionalidades mais utilizadas</p>

            <div class="m-4 d-flex gap-4 justify-content-center">

                <button id="fastActionButtons" class="btn btn-novo-curso" data-bs-toggle="modal" data-bs-target="#novoCursoModal" > <i class="fa-solid fa-graduation-cap"></i>Novo Curso</button>

                <button id="fastActionButtons" class="btn btn-novo-curso" data-bs-toggle="modal" data-bs-target="#novoCursoModal" > <i class="fa-solid fa-user"></i>Adicionar aluno</button>

                <button id="fastActionButtons" class="btn btn-novo-curso" data-bs-toggle="modal" data-bs-target="#novoCursoModal" > <i class="fa-solid fa-file"></i>Upload Documento</button>

                <button id="fastActionButtons" class="btn btn-novo-curso" data-bs-toggle="modal" data-bs-target="#novoCursoModal" > <i class="fa-solid fa-calendar-days"></i>Agendar aula</button>

                <button id="fastActionButtons" class="btn btn-novo-curso" data-bs-toggle="modal" data-bs-target="#novoCursoModal" > <i class="fa-solid fa-calendar-days"></i>Registar </button>
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
