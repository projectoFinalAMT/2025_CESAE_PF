<div class="modal fade" id="novoDocumentoModal" tabindex="-1" aria-labelledby="novoDocumentoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-12 col-md-8">
                    <h5 class="modal-title" id="novoDocumentoModalLabel">Adicionar novo Documento</h5> <small
                        class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
                </div> <button type="button" class="btn-close position-absolute top-0 end-0 m-2"
                    data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body"> <!-- FORMULARIO -->
                <form id="form-documento" action="{{ route('documento.store') }}" method="POST"
                    enctype="multipart/form-data"> @csrf <input type="hidden" name="tipo" id="tipo_documento_hidden"
                        value="pessoal"> <!-- Botões de seleção -->
                    <div class="mb-4"> <button type="button"
                            class="btn btn-novo-curso me-2 tipo-btn filtro-btn active" data-tipo="pessoal">Documento
                            Pessoal</button> <button type="button" class="btn btn-novo-curso tipo-btn filtro-btn"
                            data-tipo="apoio">Material de Apoio</button> </div>



                    @include('componentes.tipo_documento.documento_pessoal')


                    @include('componentes.tipo_documento.documento_apoio')


                    <div class="row g-3 mb-3 align-items-end">
                        <div class="col-md-8">
                            <label for="arquivo_documento" class="form-label">Selecionar Documento*</label>
                            <input type="file" class="form-control" id="arquivo_documento" name="arquivo_documento">
                        </div>
                        <div class="col-md-4">
                            <label for="tipo_documento" class="form-label">Formato do Documento*</label>
                            <select class="form-select" name="tipo_documento" id="tipo_documento">
                                <option value="" selected>Selecione o formato</option>
                                <option value="pdf">PDF</option>
                                <option value="docx">DOCX</option>
                                <option value="jpg">JPG</option>
                                <option value="png">PNG</option>
                            </select>
                        </div>
                        <small class="text-muted">O arquivo deve corresponder ao formato selecionado.</small>
                    </div>
                    <div class="col-md-8">
                              <label for="descricao" class="form-label">Descrição</label>
                              <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
                          </div>



                    <!-- Botão gravar -->
                    <div class="text-center mt-5"> <button type="submit" class="btn btn-novo-curso"> <i
                                class="bi bi-check-lg text-success"></i> Gravar Documento </button> </div>
                </form>
            </div>
        </div>
    </div>
</div>
