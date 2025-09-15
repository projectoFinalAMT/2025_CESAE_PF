@extends('layouts.fe_master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/cursos_home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modulos_home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/documentos_home.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/cursos.js') }}" defer></script>
    <script src="{{ asset('js/documentos.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js" defer></script>
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
                <h2 class="fw-bold">Documentos</h2>
                <div class="d-flex align-items-center gap-2">
                    <input type="text" class="form-control w-auto" placeholder="Pesquisar Documento..."
                        id="pesquisa-documentos">
                </div>
            </div>

            <!-- Botões filtro -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <button class="btn btn-novo-curso me-2 filtro-btn active">Material de Apoio</button>
                    <button class="btn btn-novo-curso filtro-btn ">Documentos Pessoais</button>
                </div>
                <!-- Botões ação -->
                <div class="mb-4">
                    <button id="apagarSelecionados" class="btn btn-novo-curso" style="display:none;" data-bs-toggle="modal"
                        data-bs-target="#confirmarEliminar">Apagar Selecionados</button>
                    <button id="exportarSelecionados" class="btn btn-novo-curso" style="display:none;"
                        data-bs-toggle="modal" data-bs-target="#Exportar">Exportar Documentos</button>
                    <button class="btn btn-novo-curso me-2" data-bs-toggle="modal" data-bs-target="#novoDocumentoModal">+
                        Novo Documento</button>
                </div>
            </div>

            <!-- Modal Novo Documento -->
            @include('componentes.documento.novo-documento')

            <!-- Modal de confirmação -->
            @include('componentes.documento.eliminar-documento')

            <!-- Modal de eliminar associados  -->
            @include('componentes.documento.eliminar-associados')

            <!-- Grid de documentos -->
            <div class="row g-4">
                {{-- Documentos Apoio --}}
                @foreach ($documentosApoio as $doc)
                    <div class="col-12 col-md-6 col-lg-4 card-apoio">
                        <div class="card card-cursos">
                            <div class="card-body">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-12 col-md-10">
                                        <h5 class="card-title">{{ $doc->nome }}</h5>
                                    </div>
                                    <div class="col-12 col-md-2 d-flex align-items-center justify-content-end">
                                        <div class="form-check position-absolute top-0 end-0 m-2">
                                            <input class="form-check-input" type="checkbox" value="{{ $doc->id }}"
                                                name="documentos[]" id="selecionarDoc{{ $doc->id }}">
                                            <label class="form-check-label" for="selecionarDoc{{ $doc->id }}"></label>
                                        </div>
                                    </div>
                                </div>
                                <p class="card-text fw-light">{{ $doc->descricao ?? '' }}</p>
                                <div class="d-flex justify-content-between mt-4">
                                    @php
                                        // Detecta se é link externo
                                        $isLink = Str::startsWith($doc->caminhoDocumento, ['http://', 'https://']);

                                        // Se for link, usa direto; se for arquivo, usa asset para storage
                                        $url = $isLink
                                            ? $doc->caminhoDocumento
                                            : asset(str_replace('public/', 'storage/', $doc->caminhoDocumento));
                                    @endphp

                                    @if ($isLink)
                                        <div class="">
                                            <!-- Links externos abrem na nova aba -->
                                            <a href="{{ $url }}" class="btn btn-sm btn-novo-curso"
                                                target="_blank">
                                                <i class="bi bi-box-arrow-up-right"></i> Abrir Link
                                            </a>
                                            <!-- Apagar -->
                                            <button class="btn btn-sm btn-novo-curso" data-bs-toggle="modal"
                                                data-bs-target="#confirmarEliminar" data-id="{{ $doc->id }}">
                                                <i class="bi bi-trash-fill"></i> Apagar
                                            </button>
                                        </div>
                                    @else
                                        <!-- Preview -->
                                        <a href="{{ $url }}" class="btn btn-sm btn-novo-curso" target="_self">
                                            <i class="bi bi-eye-fill"></i> Preview
                                        </a>
                                        <!-- Arquivos permitem download -->
                                        <a href="{{ $url }}" class="btn btn-sm btn-novo-curso" download>
                                            <i class="bi bi-download"></i> Download
                                        </a>
                                        <!-- Apagar -->
                                        <button class="btn btn-sm btn-novo-curso" data-bs-toggle="modal"
                                            data-bs-target="#confirmarEliminar" data-id="{{ $doc->id }}">
                                            <i class="bi bi-trash-fill"></i> Apagar
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Documentos Pessoais --}}
                @foreach ($documentosPessoais as $doc)
                    <div class="col-12 col-md-6 col-lg-4 card-pessoal" style="display:none;">
                        <div class="card card-cursos">
                            <div class="card-body">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-12 col-md-10">
                                        <h5 class="card-title">{{ $doc->nome }}</h5>

                                    </div>
                                    <div class="col-12 col-md-2 d-flex align-items-center justify-content-end">
                                        <div class="form-check position-absolute top-0 end-0 m-2">
                                            <input class="form-check-input pdfSelect" type="checkbox"
                                                value="{{ $doc->id }}" name="documentos[]"
                                                id="selecionarDoc{{ $doc->id }}"
                                                data-url="{{ asset($doc->caminhoDocumento) }}">
                                            <label class="form-check-label"
                                                for="selecionarDoc{{ $doc->id }}"></label>
                                        </div>
                                    </div>
                                </div>
                                <p class="card-text fw-light">{{ $doc->descricao ?? '' }}</p>
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="d-flex col-12 col-md-9">
    @if ($doc->dataValidade && \Carbon\Carbon::parse($doc->dataValidade)->year < 9999)
        <span class="card-text validade-doc"
              data-validade="{{ \Carbon\Carbon::parse($doc->dataValidade)->format('Y-m-d') }}">
            <!-- O JS vai preencher aqui -->
        </span>
    @else
        <span class="card-text"><i class="bi bi-infinity"></i> Vitalício</span>
    @endif
</div>

                                </div>
                                <div class="d-flex justify-content-between mt-4">
                                    @php
                                        // Detecta se é link externo
                                        $isLink = Str::startsWith($doc->caminhoDocumento, ['http://', 'https://']);

                                        // Se for link, usa direto; se for arquivo, usa asset para storage
                                        $url = $isLink
                                            ? $doc->caminhoDocumento
                                            : asset(str_replace('public/', 'storage/', $doc->caminhoDocumento));
                                    @endphp

                                    @if ($isLink)
                                        <div class="">
                                            <!-- Links externos abrem na nova aba -->
                                            <a href="{{ $url }}" class="btn btn-sm btn-novo-curso"
                                                target="_blank">
                                                <i class="bi bi-box-arrow-up-right"></i> Abrir Link
                                            </a>
                                            <!-- Apagar -->
                                            <button class="btn btn-sm btn-novo-curso" data-bs-toggle="modal"
                                                data-bs-target="#confirmarEliminar" data-id="{{ $doc->id }}">
                                                <i class="bi bi-trash-fill"></i> Apagar
                                            </button>
                                        </div>
                                    @else
                                        <!-- Preview -->
                                        <a href="{{ $url }}" class="btn btn-sm btn-novo-curso" target="_self">
                                            <i class="bi bi-eye-fill"></i> Preview
                                        </a>
                                        <!-- Arquivos permitem download -->
                                        <a href="{{ $url }}" class="btn btn-sm btn-novo-curso" download>
                                            <i class="bi bi-download"></i> Download
                                        </a>
                                        <!-- Apagar -->
                                        <button class="btn btn-sm btn-novo-curso" data-bs-toggle="modal"
                                            data-bs-target="#confirmarEliminar" data-id="{{ $doc->id }}">
                                            <i class="bi bi-trash-fill"></i> Apagar
                                        </button>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </div>
    </div>

      @include('componentes.perfil.perfil')
@endsection
