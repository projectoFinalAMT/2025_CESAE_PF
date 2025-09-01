  <div class="modal fade" id="novoCursoModal" tabindex="-1" aria-labelledby="novoCursoModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="col-12 col-md-8">
                                <h5 class="modal-title" id="novoCursoModalLabel">Adicionar novo Curso</h5>
                                <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
                            </div>
                            <button type="button" class="btn-close position-absolute top-0 end-0 m-2"
                                data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('curso.store') }}" method="POST">
                                @csrf

                                <!-- Nome do Curso -->
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome do Curso*</label>
                                    <input type="text" class="form-control" id="nome" name="nome" required>
                                </div>

                                <!-- Instituição -->
                                <div class="mb-3">
                                    <label for="instituicao" class="form-label">Instituição*</label>
                                    <select class="form-control" id="instituicao" name="instituicao" required>
                                        <option value="" selected disabled>Selecione uma instituição</option>
                                        @foreach ($instituicoes as $inst)
                                            <option value="{{ $inst->id }}">{{ $inst->nomeInstituicao }}</option>
                                        @endforeach
                                    </select>
                                    <div class="d-flex justify-content-end mt-1">
                                        <button type="button" class="btn btn-sm btn-novo-curso" data-bs-toggle="modal"
                                            data-bs-target="#novaInstituicaoModal">
                                            <i class="bi bi-building-fill"></i> Cadastrar Nova Instituição
                                        </button>
                                    </div>
                                </div>

                                <!-- Datas -->
                                <div class="row g-3 mb-3">
                                    <div class="col">
                                        <label for="data_inicio" class="form-label">Data início*</label>
                                        <input type="date" class="form-control" id="data_inicio" name="data_inicio"
                                            required>
                                    </div>
                                    <div class="col">
                                        <label for="data_fim" class="form-label">Data fim</label>
                                        <input type="date" class="form-control" id="data_fim" name="data_fim">
                                    </div>
                                </div>

                                <!-- Total horas e Preço por hora -->
                                <div class="row g-3 mb-3">
                                    <div class="col">
                                        <label for="total_horas" class="form-label">Total horas*</label>
                                        <input type="number" step="0.01" class="form-control" id="total_horas"
                                            name="total_horas" required>
                                    </div>
                                    <div class="col">
                                        <label for="preco_hora" class="form-label">Preço hora*</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" class="form-control" id="preco_hora"
                                                name="preco_hora" required>
                                            <span class="input-group-text">€</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Descrição -->
                                <div class="mb-3">
                                    <label for="descricao" class="form-label">Descrição</label>
                                    <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
                                </div>

                                <!-- Botões adicionais -->
                                <div class="d-flex gap-2 mb-3">
                                    <button type="button" class="btn btn-novo-curso"><i class="bi bi-people-fill"></i>
                                        Adicionar Alunos</button>
                                    <button type="button" class="btn btn-novo-curso"><i
                                            class="bi bi-journal-bookmark-fill"></i> Adicionar Módulos</button>
                                </div>

                                <!-- Botão submit -->
                                <div class="text-center">
                                    <button type="submit" class="btn btn-novo-curso">
                                        Gravar Curso <i class="bi bi-check-lg text-success"></i>
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
