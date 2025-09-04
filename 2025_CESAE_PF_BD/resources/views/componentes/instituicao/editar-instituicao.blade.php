 <div class="modal fade" id="editarInstituicaoModal-{{ $instituicao->id }}" tabindex="-1"
     aria-labelledby="editarInstituicaoModalLabel-{{ $instituicao->id }}" aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">

             <!-- Cabeçalho -->
             <div class="modal-header">
                 <div class="col-12 col-md-8">
                     <h5 class="modal-title" id="editarInstituicaoModalLabel-{{ $instituicao->id }}">Editar Instituição
                     </h5>
                     <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
                 </div>
                 <form method="POST" action="{{ route('instituicoes.update', $instituicao->id) }}">
                     @csrf
                     @method('PUT')
                     <!-- Coluna da direita (X + botão cor) -->
                     <div class="d-flex flex-column align-items-end">
                         <button type="button" class="btn-close mb-3" data-bs-dismiss="modal"
                             aria-label="Fechar"></button>
                         <button type="button" class="btn btn-novo-curso btn-adicionar-cor"
                             id="btnAdicionarCor-{{ $instituicao->id }}">
                             <i class="bi bi-palette-fill"></i> Alterar Cor*
                              <span id="colorPreview-{{ $instituicao->id }}" class="color-preview"></span>
                         </button>
                         <input type="color" id="inputCor-{{ $instituicao->id }}" name="cor" class="d-none" value="{{ $instituicao->cor ? $instituicao->cor : "#f5f4f4" }}">
                     </div>
             </div>

             <!-- Corpo -->
             <div class="modal-body">

                 <div class="mb-3">
                     <label for="nome_instituicao_{{ $instituicao->id }}" class="form-label">Nome da
                         Instituição*</label>
                     <input type="text" class="form-control" id="nome_instituicao_{{ $instituicao->id }}"
                         name="nomeInstituicao" required value="{{ $instituicao->nomeInstituicao }}">
                 </div>

                 <div class="mb-3">
                     <label for="morada_{{ $instituicao->id }}" class="form-label">Morada</label>
                     <input type="text" class="form-control" id="morada_{{ $instituicao->id }}" name="morada"
                         value="{{ $instituicao->morada }}">
                 </div>

                 <div class="row g-3 mb-3">
                     <div class="col-md-6">
                         <label for="nif_{{ $instituicao->id }}" class="form-label">NIF</label>
                         <input type="text" class="form-control" id="nif_{{ $instituicao->id }}" name="NIF"
                             value="{{ $instituicao->NIF }}">
                     </div>
                     <div class="col-md-6">
                         <label for="telefone_{{ $instituicao->id }}" class="form-label">Telefone</label>
                         <input type="tel" class="form-control" id="telefone_{{ $instituicao->id }}"
                             name="telefoneResponsavel" value="{{ $instituicao->telefoneResponsavel }}">
                     </div>
                 </div>

                 <div class="row g-3 mb-3">
                     <div class="col-md-6">
                         <label for="email_{{ $instituicao->id }}" class="form-label">Email*</label>
                         <input type="email" class="form-control" id="email_{{ $instituicao->id }}"
                             name="emailResponsavel" required value="{{ $instituicao->emailResponsavel }}">
                     </div>
                     <div class="col-md-6">
                         <label for="nome_responsavel_{{ $instituicao->id }}" class="form-label">Nome do
                             Responsável</label>
                         <input type="text" class="form-control" id="nome_responsavel_{{ $instituicao->id }}"
                             name="nomeResponsavel" value="{{ $instituicao->nomeResponsavel }}">
                     </div>
                 </div>

                 <div class="text-center mt-4">
                     <button type="submit" class="btn btn-novo-curso">
                         Gravar Alterações <i class="bi bi-check-lg text-success"></i>
                     </button>

                     <button type="button" class="btn btn-novo-curso" data-bs-toggle="modal"
                         data-bs-target="#confirmarEliminar" data-id="{{ $instituicao->id }}">
                         Eliminar Instituição <i class="bi bi-x-lg text-danger"></i>
                     </button>
                 </div>
                 </form>
             </div>

         </div>
     </div>
 </div>
 </div>
