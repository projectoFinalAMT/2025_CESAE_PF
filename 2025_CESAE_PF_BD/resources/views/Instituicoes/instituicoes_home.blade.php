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
                    <input type="text" class="form-control w-auto" placeholder="Pesquisar Instituição..."
                        id="pesquisa-instituicao">
                </div>
            </div>
            <!-- Botão Nova Instituição -->
            <div class="mb-4">
                <button id="apagarSelecionados" class="btn btn-novo-curso" style="display:none;" data-bs-toggle="modal"
                    data-bs-target="#confirmarEliminar">Apagar Selecionados</button>
                <button class="btn btn-novo-curso me-2" data-bs-toggle="modal" data-bs-target="#novaInstituicaoModal">+ Nova
                    Instituição</button>
                <button id="apagarSelecionados" class="btn btn-novo-curso" style="display:none;" data-bs-toggle="modal"
                    data-bs-target="#confirmarEliminar">Apagar Selecionados</button>
            </div>
        </div>

        <!-- Modal Nova Instituicao -->
        <div class="modal fade" id="novaInstituicaoModal" tabindex="-1" aria-labelledby="novaInstituicaoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="col-12 col-md-8">
                            <h5 class="modal-title" id="novaInstituicaoModalLabel">Cadastrar Nova Instituição</h5>
                            <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Ajustado -->
                        <form id="formInstituicao" method="POST" action="{{ route('instituicoes.store') }}">
                            @csrf

                            <!-- Nome da Instituição -->
                            <div class="mb-3">
                                <label for="nome_instituicao" class="form-label">Nome da Instituição*</label>
                                <input type="text" class="form-control" id="nome_instituicao" name="nomeInstituicao"
                                    required>
                            </div>

                            <!-- Morada -->
                            <div class="mb-3">
                                <label for="morada" class="form-label">Morada</label>
                                <input type="text" class="form-control" id="morada" name="morada">
                            </div>

                            <!-- NIF e Telefone -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="nif" class="form-label">NIF</label>
                                    <input type="text" class="form-control" id="nif" name="NIF">
                                </div>
                                <div class="col-md-6">
                                    <label for="telefone" class="form-label">Telefone</label>
                                    <input type="tel" class="form-control" id="telefone" name="telefoneResponsavel">
                                </div>
                            </div>

                            <!-- Email e Nome do Responsável -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email*</label>
                                    <input type="email" class="form-control" id="email" name="emailResponsavel"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label for="nome_responsavel" class="form-label">Nome do Responsável</label>
                                    <input type="text" class="form-control" id="nome_responsavel"
                                        name="nomeResponsavel">
                                </div>
                            </div>

                            <!-- Botão -->
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-novo-curso">
                                    Gravar Instituição <i class="bi bi-check-lg text-success"></i>
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
                        <p>Tem certeza que deseja eliminar esta/s Instituição/ões?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('instituicoes') }}" type="button" class="btn btn-novo-curso">
                            Cancelar <i class="bi bi-check-lg text-success"></i>
                        </a>

                        <!-- Substituir botão por formulário -->
                        <form id="formEliminar" method="POST" action="{{ route('instituicoes.deletar') }}">
                            @csrf
                            <!-- Campo hidden para os IDs selecionados -->
                            <input type="hidden" name="ids" id="idsSelecionados" value="">
                            <button type="submit" class="btn btn-novo-curso">
                                Eliminar <i class="bi bi-x-lg text-danger"></i>
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>


      <div class="row g-4">
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
                            <p class="mb-1"><strong>Telefone:</strong> {{ $instituicao->telefoneResponsavel }}</p>
                        </div>
                        <div class="col-12">
                            <p class="mb-1"><strong>Email:</strong> {{ $instituicao->emailResponsavel }}</p>
                        </div>
                        <div class="col-12">
                            <p class="mb-0"><strong>Responsável:</strong> {{ $instituicao->nomeResponsavel }}</p>
                        </div>
                    </div>

                    <!-- Rodapé -->
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-sm btn-novo-curso" data-bs-toggle="modal"
                            data-bs-target="#editarInstituicaoModal-{{ $instituicao->id }}">
                            Editar
                        </button>
                    </div>

                </div>
            </div>

            <!-- Modal Editar Instituição -->
            <div class="modal fade" id="editarInstituicaoModal-{{ $instituicao->id }}" tabindex="-1"
                aria-labelledby="editarInstituicaoModalLabel-{{ $instituicao->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <!-- Cabeçalho -->
                        <div class="modal-header">
                            <div class="col-12 col-md-8">
                                <h5 class="modal-title" id="editarInstituicaoModalLabel-{{ $instituicao->id }}">Editar Instituição</h5>
                                <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
                            </div>
                            <button type="button" class="btn-close position-absolute top-0 end-0 m-2"
                                data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>

                        <!-- Corpo -->
                        <div class="modal-body">
                            <form method="POST" action="{{ route('instituicoes.update', $instituicao->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="nome_instituicao_{{ $instituicao->id }}" class="form-label">Nome da Instituição*</label>
                                    <input type="text" class="form-control" id="nome_instituicao_{{ $instituicao->id }}"
                                        name="nomeInstituicao" required value="{{ $instituicao->nomeInstituicao }}">
                                </div>

                                <div class="mb-3">
                                    <label for="morada_{{ $instituicao->id }}" class="form-label">Morada</label>
                                    <input type="text" class="form-control" id="morada_{{ $instituicao->id }}"
                                        name="morada" value="{{ $instituicao->morada }}">
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="nif_{{ $instituicao->id }}" class="form-label">NIF</label>
                                        <input type="text" class="form-control" id="nif_{{ $instituicao->id }}"
                                            name="NIF" value="{{ $instituicao->NIF }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="telefone_{{ $instituicao->id }}" class="form-label">Telefone</label>
                                        <input type="tel" class="form-control" id="telefone_{{ $instituicao->id }}"
                                            name="telefoneResponsavel" value="{{ $instituicao->telefoneResponsavel }}">
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="email_{{ $instituicao->id }}" class="form-label">Email*</label>
                                        <input type="email" class="form-control" id="email_{{ $instituicao->id }}"
                                            name="emailResponsavel" required value="{{ $instituicao->emailResponsavel }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nome_responsavel_{{ $instituicao->id }}" class="form-label">Nome do Responsável</label>
                                        <input type="text" class="form-control" id="nome_responsavel_{{ $instituicao->id }}"
                                            name="nomeResponsavel" value="{{ $instituicao->nomeResponsavel }}">
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-novo-curso">
                                        Gravar Alterações <i class="bi bi-check-lg text-success"></i>
                                    </button>

                                    <button type="button" class="btn btn-novo-curso" data-bs-toggle="modal"
                                        data-bs-target="#confirmarEliminar" data-id="{{ $instituicao->id }}">
                                        Eliminar Instituição <i class="bi bi-x-lg text-danger"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endforeach
        </div>
    @endsection
