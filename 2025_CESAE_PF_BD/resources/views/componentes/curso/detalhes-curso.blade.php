<div class="modal fade" id="verDetalhesModal-{{ $curso->id }}" tabindex="-1"
    aria-labelledby="verDetalhesModalLabel-{{ $curso->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verDetalhesModalLabel-{{ $curso->id }}">Detalhes Curso</h5>
                <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal"
                    aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form>
                    @csrf

                    <!-- Nome do Curso -->
                    <div class="mb-3">
                        <label class="form-label">Nome do Curso*</label>
                        <input type="text" class="form-control" value="{{ $curso->titulo }}" readonly>
                    </div>

                    <!-- Instituição -->
                    <div class="mb-3">
                        <label class="form-label">Instituição*</label>
                        <input type="text" class="form-control"
                            value="{{ $curso->instituicao->nomeInstituicao ?? 'Sem Instituição' }}" readonly>
                    </div>

                    <!-- Datas, horas, preço -->
                    <div class="row g-3 mb-3">
                        <div class="col">
                            <label class="form-label">Data início*</label>
                            <input type="date" class="form-control" value="{{ $curso->dataInicio }}" readonly>
                        </div>
                        <div class="col">
                            <label class="form-label">Data fim</label>
                            <input type="date" class="form-control" value="{{ $curso->dataFim }}" readonly>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col">
                            <label class="form-label">Total horas*</label>
                            <input type="text" class="form-control" value="{{ $duracaoFormatada }}" readonly>
                        </div>
                        <div class="col">
                            <label class="form-label">Preço hora*</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ $curso->precoHora }}" readonly>
                                <span class="input-group-text">€</span>
                            </div>
                        </div>
                    </div>

                    <!-- Descrição -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Descrição</label>
                            <textarea class="form-control" rows="3" readonly>{{ $curso->descricao ?? 'Descrição não informada' }}</textarea>
                        </div>

                        <div class="col-md-4 d-flex flex-column gap-2 btn-adicionar">
                            
                            <!-- Botão para collapse de módulos -->
                            <button type="button" class="btn btn-novo-curso" data-bs-toggle="collapse"
                                data-bs-target="#modulosCollapse-{{ $curso->id }}" aria-expanded="false"
                                aria-controls="modulosCollapse-{{ $curso->id }}">
                                <i class="bi bi-journal-bookmark-fill"></i> Ver Módulos
                            </button>

                            <!-- Collapse de módulos -->
                            <div class="collapse mt-2" id="modulosCollapse-{{ $curso->id }}">
                                <div class="card card-body modulo-bloco" style="max-height: 200px; overflow-y: auto;">
                                    @foreach ($curso->modulosComAssociacao() as $modulo)
                                        @if ($modulo->associado)
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox"
                                                    value="{{ $modulo->id }}"
                                                    id="verModulo{{ $modulo->id }}-{{ $curso->id }}" checked
                                                    disabled>

                                                <label class="form-check-label"
                                                    for="verModulo{{ $modulo->id }}-{{ $curso->id }}">
                                                    <div class="texto-truncado" title="{{ $modulo->nomeModulo }}">
                                                        {{ $modulo->nomeModulo }}
                                                    </div>
                                                </label>

                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botão editar -->
                    <div class="text-center">
                        <button type="button" class="btn btn-novo-curso"
                            data-bs-target="#editarCursoModal-{{ $curso->id }}" data-bs-toggle="modal"
                            data-bs-dismiss="modal">
                            <i class="bi bi-pencil-fill"></i> Editar Curso
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
