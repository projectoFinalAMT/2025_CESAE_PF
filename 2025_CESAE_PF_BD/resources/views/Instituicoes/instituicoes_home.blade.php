@extends('layouts.fe_master')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/cursos_home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modulos_home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/documentos_home.css') }}">
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
                <h2 class="fw-bold">Instituições</h2>
                <div class="d-flex align-items-center gap-2">
                    <input type="text" class="form-control w-auto input" placeholder="Pesquisar Instituição..."
                        id="pesquisa-instituicao">
                </div>
            </div>
            <!-- Botão Nova Instituição -->
            <div class="mb-4">
                <button id="apagarSelecionados" class="btn btn-novo-curso" style="display:none;" data-bs-toggle="modal"
                    data-bs-target="#confirmarEliminar">Apagar Selecionados</button>
                <button class="btn btn-novo-curso me-2" data-bs-toggle="modal" data-bs-target="#novaInstituicaoModal">+ Nova
                    Instituição</button>
            </div>
        </div>

        <!-- Modal Nova Instituicao -->
        @include('componentes.instituicao.nova-instituicao')



        <!-- Modal de confirmação eliminar -->
        @include('componentes.instituicao.eliminar')

        @if ($instituicoes->count() > 0)
            <div class="row g-4" id="grid-instituicoes">
                @foreach ($instituicoes as $instituicao)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card card-cursos">
                            <div class="card-body">

                                <!-- Cabeçalho -->
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title mb-1">{{ $instituicao->nomeInstituicao }}</h5>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $instituicao->id }}"
                                            name="instituicoes[]" id="selecionarInstituicao{{ $instituicao->id }}">
                                        <label class="form-check-label"
                                            for="selecionarInstituicao{{ $instituicao->id }}"></label>
                                    </div>
                                </div>

                                <!-- Morada -->
                                <p class="card-text fw-light mb-3">{{ $instituicao->morada }}</p>

                                <!-- Bloco de detalhes -->
                                <div class="row g-2 mb-3">
                                    <div class="col-4">
                                        <p class="mb-1"><strong>NIF:</strong> {{ $instituicao->NIF }}</p>
                                    </div>
                                    <div class="col-6 text-end">
                                        <p class="mb-1"><strong>Telefone:</strong>
                                            {{ $instituicao->telefoneResponsavel }}
                                        </p>
                                    </div>
                                    <div class="col-12">
                                        <p class="mb-1"><strong>Email:</strong> {{ $instituicao->emailResponsavel }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="mb-0"><strong>Responsável:</strong> {{ $instituicao->nomeResponsavel }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Rodapé -->
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-sm btn-novo-curso me-2" data-bs-toggle="modal"
                                        data-bs-target="#editarInstituicaoModal-{{ $instituicao->id }}"><i
                                            class="bi bi-pencil-fill"></i>
                                        Editar
                                    </button>
                                    <button class="btn btn-sm btn-novo-curso" data-bs-toggle="modal"
                                        data-id="{{ $instituicao->id }}" data-bs-target="#confirmarEliminar"><i
                                            class="bi bi-trash-fill"></i>
                                        Apagar</button>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <!-- Modais de edição (fora da grid) -->
            @foreach ($instituicoes as $instituicao)
                @include('componentes.instituicao.editar-instituicao')
            @endforeach
        @else
            <p class="text-muted">Nenhuma Instituição cadastrada ainda.</p>
        @endif

        @include('componentes.perfil.perfil')
    @endsection
