<div class="modal fade" id="novoDocumentoModal" tabindex="-1" aria-labelledby="novoDocumentoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="col-12 col-md-8">
            <h5 class="modal-title" id="novoDocumentoModalLabel">Adicionar novo Documento</h5>
            <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
        </div>
        <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <form id="form-documento">

  <!-- Botões de seleção -->
  <div class="mb-4">
    <button type="button" class="btn btn-novo-curso me-2 tipo-btn filtro-btn active" data-tipo="pessoal">Documento Pessoal</button>
    <button type="button" class="btn btn-novo-curso tipo-btn filtro-btn" data-tipo="apoio">Material de Apoio</button>
  </div>

  <!-- Formulário Documento Pessoal -->
<div id="form-pessoal" class="form-tipo" style="display:block;">
  <div class="row g-3 mb-3">
    <div class="col-md-5">
      <label for="nome_pessoal" class="form-label">Nome do Documento*</label>
      <input type="text" class="form-control" id="nome_pessoal" name="nome_pessoal">
    </div>

    <div class="col-md-4">
      <label for="validade" class="form-label">Data de Validade*</label>
      <input type="date" class="form-control" id="validade" name="validade">
    </div>

    <div class="col-md-3 d-flex align-items-center">
      <div class="form-check mt-4">
        <input class="form-check-input" type="checkbox" id="vitalicio">
        <label class="form-check-label" for="vitalicio">Vitalício</label>
      </div>
    </div>
  </div>

  <!-- Tipo de Documento e Upload -->
  <div class="row g-3 mb-3 align-items-end">
    <div class="col-md-8">
      <label for="arquivo_documento" class="form-label">Selecionar Documento*</label>
      <input
        type="file"
        class="form-control"
        id="arquivo_documento"
        name="arquivo_documento">
    </div>
    <div class="col-md-4">
      <label for="tipo_documento" class="form-label">Formato do Documento*</label>
      <select class="form-select" id="tipo_documento" name="tipo_documento">
        <option value="" selected>Selecione o formato</option>
        <option value="pdf">PDF</option>
        <option value="docx">DOCX</option>
        <option value="jpg">JPG</option>
        <option value="png">PNG</option>
      </select>
    </div>
    <small class="text-muted">O arquivo deve corresponder ao formato selecionado.</small>
  </div>
</div>

  <!-- Formulário Material de Apoio -->
  <div id="form-apoio" class="form-tipo" style="display:none;">
    <div class="row g-3 mb-3">
      <div class="col-md-6">
        <label for="nome_apoio" class="form-label">Nome do Material*</label>
        <input type="text" class="form-control" id="nome_apoio" name="nome_apoio">
      </div>
      <div class="col-md-6">
              <label class="form-label">Módulos</label>
                <div class="dropdown">
                    <button id="btn-selecao-curso" class="btn dropdown-toggle w-100" type="button" id="dropdownCursos" data-bs-toggle="dropdown" aria-expanded="false">
                    Selecionar Módulos
                    </button>
                    <ul class="dropdown-menu w-100 p-2" aria-labelledby="dropdownCursos" style="max-height:105px; overflow-y:auto;">
                        <li>
                            <div class="form-check d-flex justify-content-between align-items-center">
                                <label class="form-check-label" for="curso1">Desenvolvimento Web</label>
                                <input class="form-check-input ms-auto" type="checkbox" value="1" id="curso1">
                            </div>
                        </li>
                        <li>
                            <div class="form-check d-flex justify-content-between align-items-center">
                            <label class="form-check-label" for="curso2">Banco de Dados</label>
                            <input class="form-check-input" type="checkbox" value="2" id="curso2">
                            </div>
                        </li>
                        <li>
                            <div class="form-check d-flex justify-content-between align-items-center">
                            <label class="form-check-label" for="curso3">Inteligência Artificial</label>
                            <input class="form-check-input" type="checkbox" value="3" id="curso3">
                            </div>
                        </li>
                        <li>
                            <div class="form-check d-flex justify-content-between align-items-center">
                            <label class="form-check-label" for="curso4">Software Developer</label>
                            <input class="form-check-input" type="checkbox" value="4" id="curso4">
                            </div>
                        </li>
                    </ul>
                </div>
      </div>

  </div>

  <!-- Tipo de Documento e Upload -->
  <div class="row g-3 mb-3 align-items-end">
    <div class="col-md-8">
      <label for="arquivo_documento" class="form-label">Selecionar Documento*</label>
      <input
        type="file"
        class="form-control"
        id="arquivo_documento"
        name="arquivo_documento">
    </div>
    <div class="col-md-4">
      <label for="tipo_documento" class="form-label">Formato do Documento*</label>
      <select class="form-select" id="tipo_documento" name="tipo_documento">
        <option value="" selected>Selecione o formato</option>
        <option value="pdf">PDF</option>
        <option value="docx">DOCX</option>
        <option value="jpg">JPG</option>
        <option value="png">PNG</option>
      </select>
    </div>
    <small class="text-muted">O arquivo deve corresponder ao formato selecionado.</small>
  </div>
</div>


  <!-- Botão gravar -->
  <div class="text-center mt-5">
    <button type="submit" class="btn btn-novo-curso"><i class=" bi bi-check-lg text-success"></i> Gravar Documento</button>
  </div>
</form>
      </div>
    </div>
  </div>
</div>
