<div class="modal fade" id="infoAlunoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content rounded-0 shadow">
        <div class="modal-header">
          <div class="col-12 col-md-8">
            <h5 class="modal-title">Info Aluno</h5>
            <small class="card-subtitle fw-light" id="alunoNomeHeader"></small>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form id="formInfoAluno" method="POST" action="{{route('alunos.update')}}">
            @method('PUT')
            @csrf

          <input type="hidden" id="aluno_id" name="aluno_id">

          <div class="modal-body">
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control rounded-0" id="nome" name="nome">
              </div>

              <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control rounded-0" id="email" name="email">
              </div>

              <div class="col-md-6">
                <label for="telefone" class="form-label">Telemóvel</label>
                <input type="text" class="form-control rounded-0" id="telefone" name="telefone">
              </div>

              <!-- … selects de instituições/cursos/módulos … -->

              <div class="col-12">
                <label for="observacoes" class="form-label">Nova Observação</label>
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
