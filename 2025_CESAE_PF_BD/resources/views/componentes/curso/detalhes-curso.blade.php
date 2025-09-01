 <div class="modal fade" id="verDetalhesModal-{{ $curso->id }}" tabindex="-1"
                            aria-labelledby="verDetalhesModalLabel-{{ $curso->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="verDetalhesModalLabel-{{ $curso->id }}">Detalhes
                                            Curso</h5>
                                        <button type="button" class="btn-close position-absolute top-0 end-0 m-2"
                                            data-bs-dismiss="modal" aria-label="Fechar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            @csrf
                                            <div class="mb-3">
                                                <label for="nome" class="form-label">Nome do Curso*</label>
                                                <input type="text" class="form-control" id="nome" name="nome"
                                                    value="{{ $curso->titulo }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="instituicao" class="form-label">Instituição*</label>
                                                <input type="text" class="form-control" id="instituicao"
                                                    name="instituicao"
                                                    value="{{ $curso->instituicao->nomeInstituicao ?? 'Sem Instituição' }}"
                                                    readonly>
                                            </div>
                                            <div class="row g-3 mb-3">
                                                <div class="col">
                                                    <label for="data_inicio" class="form-label">Data início*</label>
                                                    <input type="date" class="form-control" id="data_inicio"
                                                        name="data_inicio" value="{{ $curso->dataInicio }}" readonly>
                                                </div>
                                                <div class="col">
                                                    <label for="data_fim" class="form-label">Data fim</label>
                                                    <input type="date" class="form-control" id="data_fim"
                                                        name="data_fim" value="{{ $curso->dataFim }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row g-3 mb-3">
                                                <div class="col">
                                                    <label for="total_horas" class="form-label">Total horas*</label>
                                                    <input type="text" class="form-control" id="total_horas"
                                                        name="total_horas" value="{{ $duracaoFormatada }}" readonly>
                                                </div>
                                                <div class="col">
                                                    <label for="preco_hora" class="form-label">Preço hora*</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="preco_hora"
                                                            name="preco_hora" value="{{ $curso->precoHora }}" readonly>
                                                        <span class="input-group-text">€</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-8">
                                                    <label for="descricao" class="form-label">Descrição</label>
                                                    <textarea class="form-control" id="descricao" name="descricao" rows="3" readonly>{{ $curso->descricao ?? 'Descrição não informada' }}</textarea>
                                                </div>
                                                <div
                                                    class="col-4 d-flex flex-column gap-2 justify-content-center btn-adicionar">
                                                    <a href="" class="btn btn-novo-curso"><i
                                                            class="bi bi-people-fill"></i> Ver Alunos</a>
                                                    <a href="" class="btn btn-novo-curso"><i
                                                            class="bi bi-journal-bookmark-fill"></i> Ver Módulos</a>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="button" class="btn btn-novo-curso"
                                                    data-bs-target="#editarCursoModal-{{ $curso->id }}"
                                                    data-bs-toggle="modal" data-bs-dismiss="modal">
                                                    <i class="bi bi-pencil-fill"></i> Editar Curso
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
