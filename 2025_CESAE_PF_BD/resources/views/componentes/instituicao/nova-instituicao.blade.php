<div class="modal fade" id="novaInstituicaoModal" tabindex="-1" aria-labelledby="novaInstituicaoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header position-relative flex-column flex-md-row align-items-start">
                <!-- Título -->
                <div class="mb-2 mb-md-0 col-md-7">
                    <h5 class="modal-title" id="novaInstituicaoModalLabel">Cadastrar Nova Instituição</h5>
                    <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
                </div>
                 <form method="POST" action="{{ route('instituicoes.store') }}">
                    @csrf
                <input type="hidden" name="redirect_to" value="{{ $redirect ?? 'instituicoes' }}">
                <!-- Botão Adicionar Cor -->
                <div class="mt-4 w-md-auto d-flex justify-content-center justify-content-end">
                    <button type="button" class="btn btn-novo-curso btn-adicionar-cor" id="btnAdicionarCor">
                        <i class="bi bi-palette-fill"></i> Adicionar Cor*
                        <span id="colorPreview" class="color-preview"></span>
                    </button>
                    <input type="color" id="inputCor" name="cor" class="d-none" value="#f5f4f4">
                </div>

                <!-- Botão X absoluto -->
                <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal"
                    aria-label="Fechar"></button>
            </div>


            <div class="modal-body">

                <!-- Nome da Instituição -->
                <div class="mb-3">
                    <label for="nome_instituicao" class="form-label">Nome da Instituição*</label>
                    <input type="text" class="form-control" id="nome_instituicao" name="nomeInstituicao" required>
                </div>

                <!-- Morada -->
                <div class="mb-3">
                    <label for="morada" class="form-label">Morada</label>
                    <input type="text" class="form-control" id="morada" name="morada">
                </div>

                <!-- NIF e Telefone -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="nif" class="form-label">NIF</label>
                        <input type="text" class="form-control" id="nif" name="NIF">
                    </div>
                    <div class="col-md-6">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="tel" class="form-control" id="telefone" name="telefoneResponsavel">
                    </div>
                </div>

                <!-- Email e Nome do Responsável -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email*</label>
                        <input type="email" class="form-control" id="email" name="emailResponsavel" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nome_responsavel" class="form-label">Nome do Responsável</label>
                        <input type="text" class="form-control" id="nome_responsavel" name="nomeResponsavel">
                    </div>
                </div>

                <!-- Botão -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-novo-curso">
                        Gravar Instituição <i class="bi bi-check-lg text-success"></i>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
