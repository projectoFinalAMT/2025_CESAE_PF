  <div class="modal fade" id="novoCursoModal" tabindex="-1" aria-labelledby="novoCursoModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <div class="col-12 col-md-8">
                      <h5 class="modal-title" id="novoCursoModalLabel">Adicionar novo Curso</h5>
                      <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
                  </div>
                  <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal"
                      aria-label="Fechar"></button>
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
                              <input type="date" class="form-control" id="data_inicio" name="data_inicio" required>
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

                      <div class="row g-3 mb-3">
                          <!-- Coluna da descrição -->
                          <div class="col-md-8">
                              <label for="descricao" class="form-label">Descrição</label>
                              <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
                          </div>

                          <!-- Coluna dos botões -->
                          <div class="col-md-4 d-flex flex-column justify-content-start gap-2 btn-adicionar">
                              <!-- Botões adicionais -->
                              <!-- Botão dentro do modal -->
                              <button type="button" class="btn btn-novo-curso" data-bs-toggle="collapse"
                                  data-bs-target="#modulosCollapse">
                                  <i class="bi bi-journal-bookmark-fill"></i> Adicionar Módulos
                              </button>


                              <!-- Collapse do botão "Adicionar Módulos" -->
                              <div class="collapse mt-2" id="modulosCollapse">
                                  <div class="card card-body modulo-bloco" style="max-height: 200px; overflow-y: auto;">
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
