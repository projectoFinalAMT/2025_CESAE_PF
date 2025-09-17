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
                <h2 class="fw-bold">Módulos</h2>
                <input type="text" class="form-control w-auto ms-auto input" placeholder="Pesquisar Módulo..."
                    id="pesquisa-modulos">
            </div>
            <!-- Botão Novo Modulo -->
            <div class="mb-4">
                <button id="apagarSelecionadosAssociados" class="btn btn-novo-curso" style="display:none;"
                    data-bs-toggle="modal" data-bs-target="#confirmarEliminarAssociados">Apagar Selecionados</button>
                <button class="btn btn-novo-curso" data-bs-toggle="modal" data-bs-target="#novoModuloModal">+ Novo
                    Módulo</button>
            </div>

            <!-- Modal Novo Módulo -->
            @include('componentes.modulo.novo-modulo')

            <!-- Modal de eliminar -->
            @include('componentes.modulo.eliminar')

            <!-- Modal de eliminar associados  -->
            @include('componentes.modulo.eliminar-associoados')

            <!-- Grid de módulos -->
            @if ($modulos->count() > 0)
            <div class="row g-4" id="grid-modulos">
                @foreach ($modulos as $modulo)
                    @foreach ($modulo->cursos as $curso)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card card-cursos flex-fill d-flex flex-column position-relative">
                                <!-- Checkbox -->
                                <div class="form-check position-absolute top-0 end-0 m-2">
                                    @if (isset($cursoModuloIds[$modulo->id][$curso->id]))
                                        <input class="form-check-input" type="checkbox"
                                            value="{{ $cursoModuloIds[$modulo->id][$curso->id] }}"
                                            data-curso-modulo-id="{{ $cursoModuloIds[$modulo->id][$curso->id] }}"
                                            id="selecionarModulo{{ $modulo->id }}-{{ $curso->id }}" name="modulos[]">
                                        <label class="form-check-label"
                                            for="selecionarModulo{{ $modulo->id }}-{{ $curso->id }}"></label>
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $modulo->nomeModulo }}</h5>
                                    <h6 class="card-subtitle fw-light mb-2">
                                        {{ $curso->titulo }}
                                        ({{ $curso->instituicao->nomeInstituicao ?? 'Instituição não disponível' }})
                                    </h6>

                                    <p class="card-text fw-light flex-grow-1" style="overflow: hidden;">
                                        {{ $modulo->descricao ?? '' }}
                                    </p>

                                    <div class="d-flex justify-content-between px-3 mt-2">
                                        <span class="card-text"><i class="bi bi-file-earmark-text-fill"></i> {{ $modulo->documentos_count ?? 0 }}
                                            Documentos</span>
                                        <span class="card-text"><i class="bi bi-clock"></i>
                                            {{ $modulo->duracaoHoras }}h</span>
                                    </div>

                                    <div class="d-flex justify-content-end mt-4">
                                        <button class="btn btn-sm btn-novo-curso me-2" data-bs-toggle="modal"
                                            data-bs-target="#verDetalhesModal-{{ $modulo->id }}">
                                            <i class="bi bi-eye-fill"></i> Ver detalhes
                                        </button>
                                        <button class="btn btn-sm btn-novo-curso" data-bs-toggle="modal"
                                            data-id="{{ $modulo->id }}" data-curso="{{ $curso->id }}"
                                            data-curso="{{ $curso->id }}" data-bs-target="#confirmarEliminar"><i
                                                class="bi bi-trash-fill"></i>
                                            Apagar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Modal detalhes-->
                    @include('componentes.modulo.detalhes-modulo')

                    <!-- Modal editar-->
                    @include('componentes.modulo.editar-modulo')
                @endforeach
            </div>
             @else
                <p class="text-muted">Nenhum módulo cadastrado ainda.</p>
            @endif
        </div>
    </div>


      @include('componentes.perfil.perfil')
@endsection
