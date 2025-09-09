<div id="form-apoio" class="form-tipo" style="display:none;">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="nome_apoio" class="form-label">Nome do Material*</label>
                                <input type="text" class="form-control" id="nome_apoio" name="nome_apoio">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Módulos</label>
                                <!-- Botão para abrir o collapse -->
                                <button class="btn btn-novo-curso w-100" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#modulosCollapse" aria-expanded="false"
                                    aria-controls="modulosCollapse"><i class="bi bi-journal-bookmark-fill"></i>
                                    Adicionar Módulos
                                </button>

                                <!-- Collapse do botão "Adicionar Módulos" -->
                                <div class="collapse mt-2" id="modulosCollapse">
                                    <div class="card card-body modulo-bloco"
                                        style="max-height: 200px; overflow-y: auto;">
                                        @foreach ($modulos as $modulo)
                                            @if ($modulo->cursos->count() > 0)
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="{{ $modulo->id }}" id="modulo{{ $modulo->id }}"
                                                        name="modulos[]">

                                                    <label class="form-check-label" for="modulo{{ $modulo->id }}">
                                                        <div class="texto-truncado" title="{{ $modulo->nomeModulo }}">
                                                            {{ $modulo->nomeModulo }}
                                                        </div>
                                                    </label>

                                                    <div class="modulo-cursos ms-4 mt-1">
                                                        @foreach ($modulo->cursos as $curso)
                                                            <div class="text-muted small texto-truncado w-100"
                                                                title="{{ $curso->titulo }} - {{ $curso->instituicao->nomeInstituicao ?? 'Instituição não disponível' }}">
                                                                ({{ $curso->titulo }} -
                                                                {{ $curso->instituicao->nomeInstituicao ?? 'Instituição não disponível' }})
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tipo de Documento e Upload -->

                    </div>
