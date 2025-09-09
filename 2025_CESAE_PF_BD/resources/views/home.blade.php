@extends('layouts.fe_master')
@section('css')
<!--font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- css bootstrap -->
    <!-- css interno -->
    <link rel="stylesheet" href="{{ asset('css/dashboard_css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cursos_home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modulos_home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/documentos_home.css') }}">

    <script src="{{ asset('assets/bootstrap.js') }}" defer></script> <!--Script bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FullCalendar CSS PROPRIO -->
    <link rel="stylesheet" href="{{ asset('css/calendario/dashBladeCalendario.css') }}">


@section('content')
    <div class="content">

        <div class="container my-4">

            <!-- Título -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Dashboard</h2>
                <input type="text" class="form-control  w-auto ms-auto" placeholder="Pesquisar na Dashboard..."
                    id="pesquisa-dashboard">
                {{-- ms-auto → margem à esquerda automática, empurra o input para o final da linha.
    w-auto → limita a largura da barra de pesquisa, não ocupando todo o espaço. --}}
            </div>

            <!-- Grid dos card -->
            <div class="row g-4">
                <!-- Card 1 -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card card-info">
                        <div class="card-body">
                            <div class="row d-flex justify-content-between">
                                <div class="col d-flex align-items-center">
                                    <h5 class="titlecard mb-0">
                                        Cursos Ativos <i class="fa-solid fa-graduation-cap ms-2"></i>
                                    </h5>
                                </div>
                            </div>
                            <p class="card-text fw-bold fs-3">{{$totalCursosAtivos}}</p>
                            <div class="d-flex justify-content-between px-3">
                                <span class="card-text"><span style="font-weight: bold">{{$totalCursosInativos}}</span> inativos</span>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card card-info">
                        <div class="card-body">
                            <div class="row d-flex justify-content-between">
                                <div class="col d-flex align-items-center">
                                    <h5 class="titlecard mb-0">
                                        Total Alunos <i class="fa-solid fa-user"></i>
                                    </h5>
                                </div>
                            </div>
                            <p class="card-text fw-bold fs-3">{{$alunos->count()}}</p>
                            <div class="d-flex justify-content-between px-3">
                                <span class="card-text">{{$novosAlunos}} novos</span>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card card-info">
                        <div class="card-body">
                            <div class="row d-flex justify-content-between">
                                <div class="col d-flex align-items-center">
                                    <h5 class="titlecard mb-0">
                                        Documentos <i class="fa-solid fa-file"></i>
                                    </h5>
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
                <div class="col-12 col-md-6 col-lg-3 ">
                    <div class="card card-info ">
                        <div class="card-body ">
                            <div class="row d-flex justify-content-between">
                                <div class="col d-flex align-items-center">
                                    <h5 class="titlecard mb-0">
                                        Aulas este mês <i class="fa-solid fa-calendar-days"></i>
                                    </h5>
                                </div>
                            </div>
                            <p class="card-text fw-bold fs-3">{{$aulasTotais}}</p>
                            <div class="d-flex justify-content-between px-3">
                                <span class="card-text"> <span style="font-weight: bold">{{$aulasSemanaAtual}}</span> esta semana</span>
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
<div id="cardFilterCalendar" class="col-sm-4">
    <div id="filterBox" class="card" style="width: 18rem;">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0 ">Agendamentos</h5>
                <div class="dropdown">
                    <button class="btn btn-light btn-sm dropdown-toggle" type="button"
                        data-bs-toggle="dropdown">
                        <i class="fa-solid fa-filter"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" id="filterDropdown">
                        <li><a class="dropdown-item" href="#" data-filter="all">Hoje</a></li>
                        <li><a class="dropdown-item" href="#" data-filter="livre">Amanhã</a></li>
                        <li><a class="dropdown-item" href="#" data-filter="reuniao">Semana</a></li>
                        <li><a class="dropdown-item" href="#" data-filter="aula">Horário Livre</a></li>
                    </ul>
                </div>
            </div>

            <p id="subtitles" class="card-subtitle mb-2">Todos</p>


            <div class="container text-center">
                <!-- Header -->
                <div class="row apontamento-header">
                    <div class="col-6">Hora</div>
                    <div class="col-6">Evento</div>
                </div>
                <!-- Conteúdo -->
                <div id="apontamentosRow">
                @foreach($apontamentosHoje as $a)
                    <div class="row align-items-start apontamento-row">
                        <div class="col-6" value="{{ $a->id }}">
                            {{ date('H:i', strtotime($a->start)) }} - {{ date('H:i', strtotime($a->end)) }}
                        </div>
                        <div class="col-6">
                            {{ $a->title }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        </div>
    </div>
</div>

            {{-- MODAL: Criar/Editar Evento --}}
            <div class="modal fade" id="eventoModal" tabindex="-1" aria-labelledby="eventoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="eventoForm" class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="eventoModalLabel">Novo evento</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Fechar"></button>
                        </div>
                        <p class="informacaoAgenda">*Deve selecionar um título ou Curso para o agendamento se realizar</p>

                        <div class="modal-body">
                            <input type="hidden" id="event_id">
                            <div class="mb-3">
                                <label class="form-label">Título (opcional)</label>
                                <input type="text" id="event_title" class="form-control"
                                    placeholder="Ex.: Reunião com coordenação">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Curso (opcional)</label>
                                <select id="event_curso" class="form-select">
                                  <option value="">— Sem Curso —</option>
                                  @foreach($mCurso as $c)
                                    <option value="{{ $c->id }}">{{ $c->titulo }}</option>
                                  @endforeach
                                </select>
                              </div>

                              <div class="mb-3">
                                <label class="form-label">Módulo (opcional)</label>
                                <select id="event_modulo" class="form-select">
                                  <option value="">— Sem módulo —</option>
                                  @foreach($modulos as $m)
                                    <option value="{{ $m->id }}">{{ $m->nomeModulo }}</option>
                                  @endforeach
                                </select>
                              </div>

                            <div class="row g-2">
                                <div class="col-6">
                                    <label class="form-label">Início</label>
                                    <input type="datetime-local" id="event_inicio" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Fim</label>
                                    <input type="datetime-local" id="event_fim" class="form-control">
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label">Nota (opcional)</label>
                                <textarea id="event_nota" class="form-control" rows="2" placeholder="Ex.: trazer projector"></textarea>
                            </div>

                            <div id="eventoErro" class="text-danger mt-2" style="display:none;"></div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" id="btnApagar" class="btn btn-outline-danger me-auto"
                                style="display:none;">Apagar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- quick actions -->
        <div class="row my-4 justify-content-center">
            <div id="fastAction" class="col-12">
                <h5 class="title">Ações rápidas</h5>
                <p id="subtitle">Acesso rápido às funcionalidades mais utilizadas</p>

                <div class="m-4 d-flex flex-wrap gap-3 justify-content-center">
                    <button class="btn btn-novo-curso d-flex align-items-center gap-2 p-3" data-bs-toggle="modal"
                        data-bs-target="#novoCursoModal">
                        <i class="fa-solid fa-graduation-cap"></i> Novo Curso
                    </button>

                    <button class="btn btn-novo-curso d-flex align-items-center gap-2 p-3" data-bs-toggle="modal"
                        data-bs-target="#novoCursoModal">
                        <i class="fa-solid fa-user"></i> Adicionar Aluno
                    </button>

                    <button class="btn btn-novo-curso d-flex align-items-center gap-2 p-3" data-bs-toggle="modal"
                        data-bs-target="#novoCursoModal">
                        <i class="fa-solid fa-file"></i> Upload Documento
                    </button>

                    <button class="btn btn-novo-curso d-flex align-items-center gap-2 p-3" data-bs-toggle="modal"
                        data-bs-target="#novoCursoModal">
                        <i class="fa-solid fa-calendar-days"></i> Agendar Aula
                    </button>

                    <button class="btn btn-novo-curso d-flex align-items-center gap-2 p-3" data-bs-toggle="modal"
                        data-bs-target="#novoCursoModal">
                        <i class="fa-solid fa-building"></i> Registar Instituição
                    </button>
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
@if ($cursos->count() > 0)
    <div class="row g-4">
        @foreach ($cursos as $curso)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card card-cursos shadow-sm h-100 position-relative">

                    <!-- Status ativo/inativo no canto superior direito -->
                    <span class="status {{ $curso->ativo ? 'ativo' : 'inativo' }} position-absolute top-0 end-0 m-3">
                        {{ $curso->ativo ? 'ativo' : 'inativo' }}
                    </span>

                    <div class="card-body">
                        <h5 class="card-title">{{ $curso->nome }}</h5>

                        @if ($curso->subtitulo)
                            <h6 class="card-subtitle fw-light mb-4">{{ $curso->subtitulo }}</h6>
                        @endif

                        <p class="card-text fw-light">{{ $curso->descricao }}</p>

                        @if ($curso->modulos || $curso->horas || $curso->alunos)
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
@endif --}}
    </div>

    <!--MODALS-->
    <!--Modal curso-->
    {{-- @include('components.modalCurso')
    <!--.Modal curso-->
    <!--Modal aluno-->
    @include('components.modalCurso')
    <!--.Modal aluno-->
    <!--Modal Doc-->
    @include('components.modalCurso')
    <!--.Modal Doc-->
    <!--Modal Aula-->
    @include('components.modalCurso')
    <!--.Modal Aula-->
    <!--Modal Instituicao-->
    @include('components.modalCurso') --}}
    <!--.Modal Instituicao-->
    <!--.MODALS-->

@section('scripts')
    <!-- IMPORTANTE: JS do FullCalendar (usa o bundle global) -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <!-- Passar CSRF token para o JS -->
    <script>
        window.csrfToken = "{{ csrf_token() }}";
    </script>
    <!-- Nosso JS -->
    <script src="{{ asset('js/calendario.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
@endsection
