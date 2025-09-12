        <div class="modal fade" id="novoUserModal" tabindex="-1" aria-labelledby="novouserModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <!-- Cabeçalho -->
                        <div class="modal-header d-flex align-items-center">
                            <!-- Foto e nome do perfil à esquerda -->
                            <div class="profile text-center me-3">
                                <img src="" alt="Foto de perfil" class="rounded-circle mb-2" width="90"
                                    height="90">
                                <h6 class="mb-0">Nome</h6>
                            </div>

                            <!-- Título e subtítulo -->
                            <div class="flex-grow-1">
                                <h5 class="modal-title" id="novoUserModalLabel">O meu Perfil</h5>
                                <small class="card-subtitle fw-light">Campos com * são obrigatórios.</small>
                            </div>

                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Fechar"></button>
                        </div>

                        <!-- Corpo do modal -->
                        <div class="modal-body">
                            <form id="formUser">
                                @csrf

                                <!-- Botões adicionar foto e alterar password lado a lado -->
                                <div class="row g-3 mb-3">
                                    <div class="col d-flex gap-2 justify-content-end">
                                        <button type="button" class="btn btn-novo-curso"><i class="bi bi-people"></i>
                                            Adicionar Foto</button>
                                        <button type="button" class="btn btn-novo-curso"><i
                                                class="bi bi-shield-lock"></i> Alterar Password</button>
                                    </div>
                                </div>

                                <!-- Linha 1: Nome -->
                                <div class="mb-3">
                                    <label for="nome_user" class="form-label">Nome Completo*</label>
                                    <input type="text" class="form-control" id="nome_user" name="nome_user" required>
                                </div>

                                <!-- Linha 2: Morada -->
                                <div class="mb-3">
                                    <label for="morada" class="form-label">Morada</label>
                                    <input type="text" class="form-control" id="morada" name="morada">
                                </div>

                                <!-- Linha 3: Email e Telefone -->
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" class="form-control" id="email" name="email">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="telefone" class="form-label">Telefone</label>
                                        <input type="tel" class="form-control" id="telefone" name="telefone">
                                    </div>
                                </div>

                                <!-- Botão Gravar centralizado -->
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-novo-curso">
                                        Gravar <i class="bi bi-check-lg text-success"></i>
                                    </button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
