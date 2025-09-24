@extends('layouts.fe_master')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/cursos_home.css') }}">
     <link rel="stylesheet" href="{{ asset('css/modulos_home.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('js/cursos.js') }}" defer></script>
    <script src="{{ asset('js/documentos.js') }}" defer></script>
@endsection
@section('content')
    <div class="content">
        <div class="container my-4">
            <!-- Toast de sucesso -->
            @if (session('success'))
                <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
                    <div id="successToast" class="toast align-items-center text-bg-success border-0 show" role="alert"
                        aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                {{ session('success') }}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                                aria-label="Fechar"></button>
                        </div>
                    </div>
                </div>
            @endif
            <!-- Título -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Cursos</h2>
                <input type="text" class="form-control w-auto ms-auto input" placeholder="Pesquisar Curso..."
                    id="pesquisa-cursos">
            </div>
            <!-- Botão Novo Curso -->
            <div class="mb-4">
                <button class="btn btn-novo-curso" data-bs-toggle="modal" data-bs-target="#novoCursoModal">+ Novo
                    Curso</button>
            </div>

            <!-- Modal Novo Curso -->
            @include('componentes.curso.novo-curso')

            <!-- Modal Nova Instituicao -->
            @include('componentes.instituicao.nova-instituicao', ['redirect' => 'cursos'])

            <!-- Modal de confirmação -->
            @include('componentes.curso.eliminar')

            <!-- Grid de cursos -->
            @if ($cursos->count() > 0)
                <div class="row g-4" id="grid-cursos">
                    @foreach ($cursos as $curso)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card card-cursos h-100 position-relative">

                                <!-- Status ativo/inativo no canto superior direito -->
                                <span
                                    class="status-btn status {{ $curso->estado_cursos_id == 1 ? 'ativo' : 'inativo' }} position-absolute top-0 end-0 m-3 btn-novo-curso"
                                    data-curso-id="{{ $curso->id }}" data-estado="{{ $curso->estado_cursos_id }}"
                                    style="cursor:pointer;">
                                    {{ $curso->estado_cursos_id == 1 ? 'ativo' : 'inativo' }}
                                </span>

                                <div class="card-body">
                                    <div class="row d-flex justify-content-between">
                                        <div class="col-12 col-md-8">
                                            <h5 class="card-title text-truncate"
                                                style="white-space: nowrap; overflow: hidden;">
                                                {{ $curso->titulo }}
                                            </h5>
                                            <h6 class="card-subtitle fw-light mb-4 text-truncate"
                                                style="white-space: nowrap; overflow: hidden;">
                                                {{ $curso->instituicao->nomeInstituicao ?? 'Sem Instituição' }}
                                            </h6>
                                        </div>
                                    </div>

                                    <p class="card-text fw-light">{{ $curso->descricao ?? '' }}</p>

                                    @php
                                        $totalHoras = $curso->duracaoTotal ?? 0;
                                        $horas = floor($totalHoras);
                                        $minutos = round(($totalHoras - $horas) * 60);
                                        $duracaoFormatada =
                                            $horas . 'h' . ($minutos > 0 ? '&nbsp;' . $minutos . 'M' : '');
                                    @endphp

                                    <div class="d-flex justify-content-between px-2 align-items-center"
                                        style="white-space: nowrap; font-size: 0.9rem;">
                                        <span class="card-text flex-shrink-1 text-truncate">
                                            <i class="bi bi-journal-bookmark-fill"></i> {{ $curso->modulos_count ?? 0 }}
                                            Módulos
                                        </span>
                                        <span class="card-text flex-shrink-1 text-truncate">
                                            <i class="bi bi-clock"></i> {!! $duracaoFormatada !!}
                                        </span>
                                        <span class="card-text flex-shrink-1 text-truncate">
                                            <i class="bi bi-people-fill"></i> {{ $curso->alunos_count ?? 0 }} Alunos
                                        </span>
                                    </div>


                                    <div class="d-flex justify-content-end mt-4">
                                        <button class="btn btn-sm btn-novo-curso me-2" data-bs-toggle="modal"
                                            data-bs-target="#verDetalhesModal-{{ $curso->id }}">
                                            <i class="bi bi-eye-fill"></i> Ver detalhes
                                        </button>
                                        <button class="btn btn-sm btn-novo-curso" data-bs-toggle="modal"
                                            data-id="{{ $curso->id }}" data-bs-target="#confirmarEliminar"><i
                                                class="bi bi-trash-fill"></i> Apagar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal de detalhes do curso -->
                       @include('componentes.curso.detalhes-curso')

                        <!-- Modal Editar Curso -->
                        @include('componentes.curso.editar-curso')
                    @endforeach
                </div>
            @else
                <p class="text-muted">Nenhum curso cadastrado ainda.</p>
            @endif


        </div>

          @include('componentes.perfil.perfil')
    @endsection
