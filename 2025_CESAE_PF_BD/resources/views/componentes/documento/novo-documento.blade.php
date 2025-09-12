<div class="modal fade" id="novoDocumentoModal" tabindex="-1" aria-labelledby="novoDocumentoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-12 col-md-8">
                    <h5 class="modal-title" id="novoDocumentoModalLabel">Adicionar novo Documento</h5>
                    <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
                </div>
                <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal"
                    aria-label="Fechar"></button>
            </div>

            <div class="modal-body"> <!-- FORMULARIO -->
                <form id="form-documento" action="{{ route('documento.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="tipo" id="tipo_documento_hidden" value="pessoal">

                    <!-- Botões de seleção -->
                    <div class="mb-4">
                        <button type="button" class="btn btn-novo-curso me-2 tipo-btn filtro-btn active"
                            data-tipo="pessoal">Documento Pessoal</button>
                        <button type="button" class="btn btn-novo-curso tipo-btn filtro-btn" data-tipo="apoio">Material
                            de Apoio</button>
                    </div>

                    @include('componentes.tipo_documento.documento_pessoal')
                    @include('componentes.tipo_documento.documento_apoio')


                    <div class="row g-3 mb-3 align-items-start">
                        <!-- Descrição -->
                        <div class="col-md-7  d-flex flex-column">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="4"></textarea>
                        </div>
                        <!-- Escolha Upload ou Link -->
                        <div class="col-md-5  d-flex flex-column">
                            <label class="form-label">Origem do Documento*</label>
                            <select id="origem_documento" class="form-select">
                                <option value="arquivo" selected>Upload de Arquivo</option>
                                <option value="link">Link Externo</option>
                            </select>
                        </div>
                    </div>

                    <!-- Campos de Upload (default visível) -->
                    <div class="row g-3 mb-3 align-items-end" id="campo-arquivo">
                        <div class="col-md-7">
                            <label for="arquivo_documento" class="form-label">Selecionar Documento*</label>
                            <input type="file" class="form-control" id="arquivo_documento" name="arquivo_documento">
                        </div>
                    </div>

                    <!-- Campo de Link (default escondido) -->
                    <div class="mb-3 d-none" id="campo-link">
                        <label for="link_documento" class="form-label">Colar Link do Documento*</label>
                        <input type="url" class="form-control" id="link_documento" name="link_documento"
                            placeholder="https://...">
                    </div>

                    <!-- Botão gravar -->
                    <div class="text-center mt-5">
                        <button type="submit" class="btn btn-novo-curso">
                            <i class="bi bi-check-lg text-success"></i> Gravar Documento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
