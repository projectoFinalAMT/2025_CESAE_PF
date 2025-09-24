<div class="modal fade" id="verDetalhesModal-{{ $modulo->id }}" tabindex="-1"
    aria-labelledby="verDetalhesModalLabel-{{ $modulo->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Cabeçalho -->
            <div class="modal-header">
                <div class="col-12 col-md-8">
                    <h5 class="modal-title" id="verDetalhesModalLabel-{{ $modulo->id }}">Detalhes do Módulo</h5>
                </div>
                <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal"
                    aria-label="Fechar"></button>
            </div>

            <!-- Corpo -->
            <div class="modal-body">
                <form>
                    <!-- Nome do módulo e Cursos -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nome do Módulo*</label>
                            <input type="text" class="form-control" value="{{ $modulo->nomeModulo }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Cursos*</label>
                            <div class="form-check-container w-100 p-2"
                                style="max-height:105px; overflow-y:auto; border:1px solid #ccc; border-radius:0.25rem;">
                                @foreach ($modulo->cursos as $curso)
                                    <div class="form-check d-flex justify-content-between align-items-center">
                                        <label class="form-check-label" for="curso{{ $curso->id }}">
                                            {{ $curso->titulo }}
                                            ({{ $curso->instituicao->nomeInstituicao ?? 'Instituição não disponível' }})
                                        </label>
                                        <input class="form-check-input ms-auto" type="checkbox"
                                            value="{{ $curso->id }}" id="curso{{ $curso->id }}" checked readonly>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Total horas -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Total horas*</label>
                            <input type="number" class="form-control" value="{{ $modulo->duracaoHoras }}" readonly>
                        </div>
                    </div>

                    <!-- Descrição e documento -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Descrição</label>
                            <textarea class="form-control" rows="3" readonly> {{ $modulo->descricao ?? '' }}</textarea>
                        </div>
                        <!-- Botão para collapse de módulos -->
                        <div class="col-md-4 d-flex flex-column gap-2 ms-5">
                            <button type="button" class="btn btn-novo-curso mt-2" data-bs-toggle="collapse"
                                data-bs-target="#modulosCollapse-{{ $modulo->id }}" aria-expanded="false"
                                aria-controls="modulosCollapse-{{ $modulo->id }}">
                                <i class="bi bi-file-earmark-text-fill"></i> Ver Documentos
                            </button>

                            <!-- Collapse de módulos -->
                            <!-- Collapse de módulos -->
<div class="collapse mt-2" id="modulosCollapse-{{ $modulo->id }}">
    <div class="card card-body modulo-bloco" style="max-height: 200px; overflow-y: auto;">
        @foreach ($modulo->documentosComAssociacao() as $doc)
            @if ($doc->associado)
                @php
                    // Detecta se é link externo
                    $isLink = Str::startsWith($doc->caminhoDocumento, ['http://', 'https://']);
                    // Se for link, usa direto; se for arquivo, usa asset para storage
                    $url = $isLink
                        ? $doc->caminhoDocumento
                        : asset(str_replace('public/', 'storage/', $doc->caminhoDocumento));
                @endphp

                <div class="form-check mb-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <input class="form-check-input me-2" type="checkbox"
                               value="{{ $doc->id }}" id="verDoc{{ $doc->id }}-{{ $modulo->id }}" checked disabled>
                        <label class="form-check-label texto-truncado" for="verDoc{{ $doc->id }}-{{ $modulo->id }}"
                               title="{{ $doc->nome }}">
                            {{ $doc->nome }} ({{ strtoupper($doc->formatoDocumento->nomeFormato ?? 'PDF') }})
                        </label>
               
                        <!-- Preview -->
                        <a href="{{ $url }}" class="btn btn-sm" id="preview" target="_self">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                        <!-- Download -->
                        <a href="{{ $url }}" class="btn btn-sm" id="preview" download>
                            <i class="bi bi-download"></i>
                        </a>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

                        </div>
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-novo-curso"
                            data-bs-target="#editarModuloModal-{{ $modulo->id }}" data-bs-toggle="modal"
                            data-bs-dismiss="modal">
                            <i class="bi bi-pencil-fill"></i> Editar Módulo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
