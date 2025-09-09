<div class="modal fade" id="novoModuloModal" tabindex="-1" aria-labelledby="novoModuloModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-12 col-md-8">
                    <h5 class="modal-title" id="novoModuloModalLabel">Adicionar novo Módulo</h5>
                    <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
                </div>
                <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal"
                    aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('modulo.store') }}">
                    @csrf
                    <!-- Nome do módulo e dropdown de cursos -->
                    <div class="row g-3 mb-3">
                        <!-- Coluna do módulo + total horas -->
                        <div class="col-md-6 d-flex flex-column">
                            <label for="nome" class="form-label">Nome do Módulo*</label>
                            <input type="text" class="form-control mb-2" id="nome" name="nome" required>

                            <label for="total_horas" class="form-label">Total horas*</label>
                            <input type="number" step="0.01" class="form-control" id="total_horas"
                                name="duracao_horas" required>
                        </div>

                        <!-- Coluna de cursos -->
                        <div class="col-md-6">
                            <label class="form-label">Cursos*</label>
                            <div class="form-check-container w-100 p-2"
                                style="max-height:105px; overflow-y:auto; border:1px solid #ccc; border-radius:0.25rem;">
                                @foreach ($cursos as $curso)
                                    <div class="form-check d-flex justify-content-between align-items-center">
                                        <label class="form-check-label" for="curso{{ $curso->id }}">
                                            {{ $curso->titulo }} ({{ $curso->instituicao->nomeInstituicao }})
                                        </label>
                                        <input class="form-check-input ms-auto curso-checkbox" type="checkbox"
                                            value="{{ $curso->id }}" id="curso{{ $curso->id }}" name="cursos[]">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Descrição e botão adicionar documentos -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
                        </div>

                        <div class="col-md-4 d-flex flex-column gap-2 btn-adicionar ms-5">
                            <!-- Botão add modulos -->
                            <button type="button" class="btn btn-novo-curso" data-bs-toggle="collapse"
                                data-bs-target="#modulosCollapse">
                                <i class="bi bi-file-earmark-text-fill"></i> Adicionar Documentos
                            </button>
                            <!-- Collapse do botão "Adicionar Módulos" -->
                            <div class="collapse mt-2" id="modulosCollapse">
                                <div class="card card-body modulo-bloco">
                                    @foreach ($documentos as $doc)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $doc->id }}"
                                                id="documento{{ $doc->id }}" name="documentos[]">

                                            <label class="form-check-label" for="documento{{ $doc->id }}">
                                                <div class="texto-truncado" title="{{ $doc->nome }}">
                                                    {{ $doc->nome }}
                                                </div>

                                                <div class="modulo-cursos">
                                                    @foreach ($doc->modulos as $modDoc)
                                                        <div class="text-muted small texto-truncado w-100"
                                                            title="{{ $modDoc->nome }}">
                                                            {{ $modDoc->nome }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>


                        </div>
                    </div>

                    <!-- Botão gravar módulo -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-novo-curso">Gravar Módulo <i
                                class="bi bi-check-lg text-success"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
