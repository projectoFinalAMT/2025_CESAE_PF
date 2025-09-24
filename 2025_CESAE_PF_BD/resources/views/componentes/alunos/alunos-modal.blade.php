<!-- Modal: Adicionar Aluno -->
<div class="modal fade" id="alunoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content rounded-0 shadow">
        <div class="modal-header">
          <div class="col-12 col-md-8">
            <h5 class="modal-title">Adicionar novo aluno</h5>
            <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form id="alunoForm" method="POST" action="{{ route('alunos.store') }}">
          @csrf
          <div class="modal-body">
            <div class="row g-3 mb-3">
              <!-- Nome -->
              <div class="col-md-6">
                <label for="nome" class="form-label">Nome aluno*</label>
                <input type="text" class="form-control rounded-0" id="nome" name="nome" required>
              </div>

              <!-- Email -->
              <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control rounded-0" id="email" name="email">
              </div>

              <!-- Telemóvel -->
              <div class="col-md-6">
                <label for="telefone" class="form-label">Telemóvel</label>
                <input type="text" class="form-control rounded-0" id="telefone" name="telefone">
              </div>

              <!-- Instituições (multi) -->
              <div class="col-md-6">
                <label for="instituicao_ids" class="form-label">Instituições*</label>
                <select class="form-control"
                        id="instituicao_ids"
                        name="instituicao_ids[]"
                        multiple
                        size="6"
                        required>
                  @foreach($instituicoes ?? [] as $inst)
                    <option value="{{ $inst->id }}">{{ $inst->nomeInstituicao }}</option>
                  @endforeach
                </select>
                <small class="text-muted">Segura Ctrl/⌘ para escolher várias.</small>
              </div>

              <!-- Cursos (multi, dependente das instituições) -->
              <div class="col-md-6">
                <label for="curso_ids" class="form-label">Cursos*</label>
                <select class="form-control"
                        id="curso_ids"
                        name="curso_ids[]"
                        multiple
                        size="6"
                        required
                        disabled>
                </select>
                <small class="text-muted">Escolhe primeiro as instituições.</small>
              </div>

              <!-- Módulos (multi, dependente dos cursos) -->
              <div class="col-md-6">
                <label for="modulo_ids" class="form-label">Módulos* </label>
                <select class="form-control"
                        id="modulo_ids"
                        name="modulo_ids[]"
                        multiple
                        size="6"
                        required
                        disabled>
                </select>
                <small class="text-muted">Escolhe primeiro os cursos.</small>
              </div>

              <!-- Observações -->
              <div class="col-12">
                <label for="observacoes" class="form-label">Observações</label>
                <textarea class="form-control rounded-0" id="observacoes" name="observacoes" rows="3"></textarea>
              </div>
            </div>

            <div id="alunoErro" class="text-danger" style="display:none;"></div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary rounded-0">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
