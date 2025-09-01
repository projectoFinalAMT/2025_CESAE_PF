<div class="modal fade" id="editarCursoModal-{{ $curso->id }}" tabindex="-1"
    aria-labelledby="editarCursoModalLabel-{{ $curso->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-12 col-md-8">
                    <h5 class="modal-title" id="editarCursoModalLabel">Editar Curso</h5>
                    <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
                </div>
                <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal"
                    aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('curso.update', $curso->id) }}">
                    @csrf
                    @method('PUT') <!-- importante para enviar como PUT -->

                    <!-- Nome do curso -->
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Curso*</label>
                        <input type="text" class="form-control" id="nome" name="nome"
                            value="{{ $curso->titulo }}">
                    </div>

                    <!-- Instituição -->
                    <div class="mb-3">
                        <label for="instituicao" class="form-label">Instituição*</label>
                        <select class="form-control" id="instituicao" name="instituicao" required>
                            <option value="" disabled>Selecione uma instituição</option>
                            @foreach ($instituicoes as $inst)
                                <option value="{{ $inst->id }}"
                                    {{ $curso->instituicoes_id == $inst->id ? 'selected' : '' }}>
                                    {{ $inst->nomeInstituicao }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Datas, horas, preço, descrição... -->
                    <div class="row g-3 mb-3">
                        <div class="col">
                            <label for="data_inicio" class="form-label">Data início*</label>
                            <input type="date" class="form-control" id="data_inicio" name="data_inicio"
                                value="{{ $curso->dataInicio }}">
                        </div>
                        <div class="col">
                            <label for="data_fim" class="form-label">Data fim</label>
                            <input type="date" class="form-control" id="data_fim" name="data_fim"
                                value="{{ $curso->dataFim }}">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col">
                            <label for="total_horas" class="form-label">Total horas*</label>
                            <input type="number" step="0.1" class="form-control" id="total_horas"
                                name="total_horas" value="{{ $curso->duracaoTotal }}">
                        </div>
                        <div class="col">
                            <label for="preco_hora" class="form-label">Preço hora*</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="preco_hora" name="preco_hora"
                                    value="{{ $curso->precoHora }}">
                                <span class="input-group-text">€</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3">{{ $curso->descricao ?? 'Descrição não informada' }}</textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-novo-curso">
                            Gravar Alterações <i class="bi bi-check-lg text-success"></i>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
