//Aparecer Botão Selecionado
document.addEventListener("DOMContentLoaded", () => {
    const apagarBtn = document.getElementById("apagarSelecionados");
    const checkboxes = document.querySelectorAll(
        ".card-cursos .form-check-input"
    );

    checkboxes.forEach((cb) => {
        cb.addEventListener("change", () => {
            // Mostrar botão se pelo menos 1 checkbox estiver marcado
            const algumSelecionado = Array.from(checkboxes).some(
                (c) => c.checked
            );

            if (apagarBtn) {
                apagarBtn.style.display = algumSelecionado
                    ? "inline-block"
                    : "none";
            }
        });
    });
});

//formulario Doc
document.addEventListener("DOMContentLoaded", () => {
    const botoesFiltro = document.querySelectorAll(".filtro-btn");
    const cardsApoio = document.querySelectorAll(".card-apoio");
    const cardsPessoais = document.querySelectorAll(".card-pessoal");


    botoesFiltro.forEach((botao) => {
        botao.addEventListener("click", () => {
            // tirar active de todos
            botoesFiltro.forEach((b) => b.classList.remove("active"));
            botao.classList.add("active");

            // mostrar/esconder conforme o botão
            if (botao.textContent.includes("Apoio")) {
                 cardsApoio.forEach(c => c.style.display = "block");
                 cardsPessoais.forEach(c => c.style.display = "none");
            } else {
                 cardsApoio.forEach(c => c.style.display = "none");
                 cardsPessoais.forEach(c => c.style.display = "block");
            }
        });
    });
});


//Eliminar Card
document.addEventListener("DOMContentLoaded", function () {
    const confirmarEliminarModal = document.getElementById("confirmarEliminar");
    const formEliminar = document.getElementById("formEliminar");
    const idsSelecionados = document.getElementById("idsSelecionados");
    const cursoSelecionado = document.getElementById("cursoSelecionado");

    // Single delete via botão do card
    if(confirmarEliminarModal){
    confirmarEliminarModal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute("data-id");
        const cursoId = button.getAttribute("data-curso"); // pega o curso específico do card

        if (id) {
            idsSelecionados.value = id;
        }

        if (cursoId) {
            cursoSelecionado.value = cursoId;
        }

    });
    }

    // Multi delete (cursos, instituições, módulos, documentos)
    if(formEliminar){
    formEliminar.addEventListener("submit", function (e) {
        const ids = [];

        // Cursos selecionados
        document
            .querySelectorAll('input[name="cursos[]"]:checked')
            .forEach((cb) => ids.push(cb.value));

        // Instituições selecionadas
        document
            .querySelectorAll('input[name="instituicoes[]"]:checked')
            .forEach((cb) => ids.push(cb.value));

        // Módulos selecionados
        document
            .querySelectorAll('input[name="modulos[]"]:checked')
            .forEach((cb) => ids.push(cb.value));

            // Documentos selecionados
        document
            .querySelectorAll('input[name="documentos[]"]:checked')
            .forEach((cb) => ids.push(cb.value));

        // Se nenhum item selecionado
        if (ids.length === 0 && !idsSelecionados.value) {
            e.preventDefault();
            alert("Selecione pelo menos um item para deletar.");
            return;
        }

        // Preenche o hidden apenas se ainda estiver vazio
        if (idsSelecionados.value === "") {
            idsSelecionados.value = ids.join(",");
        }
    });
    }
});

//Aparecer Botão Selecionado
document.addEventListener("DOMContentLoaded", () => {
    const apagarBtn = document.getElementById("apagarSelecionados");
    const exportarBtn = document.getElementById("exportarSelecionados");
    const checkboxes = document.querySelectorAll(".card-cursos .form-check-input");

    checkboxes.forEach((cb) => {
        cb.addEventListener("change", () => {
            const algumSelecionado = Array.from(checkboxes).some((c) => c.checked);

            apagarBtn.style.display = algumSelecionado ? "inline-block" : "none";

            // Só mostra exportar se o selecionado for de um card pessoal
            const algumPessoalSelecionado = Array.from(checkboxes).some(
                (c) => c.checked && c.closest(".card-pessoal")
            );

            exportarBtn.style.display = algumPessoalSelecionado
                ? "inline-block"
                : "none";
        });
    });
});

//Aparecer Botão Selecionado Modulo
document.addEventListener("DOMContentLoaded", () => {
    const apagarBtn = document.getElementById("apagarSelecionadosAssociados");
    const checkboxes = document.querySelectorAll(
        ".card-cursos .form-check-input"
    );

    checkboxes.forEach((cb) => {
        cb.addEventListener("change", () => {
            // Mostrar botão se pelo menos 1 checkbox estiver marcado
            const algumSelecionado = Array.from(checkboxes).some(
                (c) => c.checked
            );
            apagarBtn.style.display = algumSelecionado
                ? "inline-block"
                : "none";


        });
    });
});

//eliminar Modolo/Curso
document.addEventListener("DOMContentLoaded", function () {
    const btnApagarSelecionados = document.getElementById(
        "apagarSelecionadosAssociados"
    );
    const idsSelecionadosInput = document.getElementById(
        "idsSelecionadosModulo"
    );

    if (!btnApagarSelecionados || !idsSelecionadosInput) return; // evita o erro

    btnApagarSelecionados.addEventListener("click", function () {
        // Pega apenas checkboxes marcados
        const selecionados = Array.from(
            document.querySelectorAll('input[name="modulos[]"]:checked')
        )
            .map((cb) => cb.dataset.cursoModuloId)
            .filter((id) => id); // remove vazios

        if (selecionados.length === 0) {
            alert("Selecione pelo menos um módulo.");
            return;
        }

        // Preenche o hidden input do form

        idsSelecionadosInput.value = selecionados.join(",");
    });
});

// Eliminar Documento/Modulo
document.addEventListener("DOMContentLoaded", function () {
    const btnApagarSelecionados = document.getElementById(
        "apagarSelecionadosDocModulo"
    );
    const idsSelecionadosInput = document.getElementById(
        "idsSelecionadosDocumentoModulo"
    );

    if (!btnApagarSelecionados || !idsSelecionadosInput) return;

    btnApagarSelecionados.addEventListener("click", function () {
        // Pega apenas checkboxes marcados
        const selecionados = Array.from(
            document.querySelectorAll('input[name="documento_modulos[]"]:checked')
        )
            .map((cb) => cb.dataset.documentoModuloId)
            .filter((id) => id); // remove vazios

        if (selecionados.length === 0) {
            alert("Selecione pelo menos um documento.");
            return;
        }

        // Preenche o hidden input do form
        idsSelecionadosInput.value = selecionados.join(",");
    });
});

//tempo post sucess
document.addEventListener("DOMContentLoaded", function () {
    const toastEl = document.getElementById("successToast");
    if (toastEl) {
        const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
        toast.show();
    }
});

//mudar botao Ativo/Inativo
document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".status-btn");

    buttons.forEach((button) => {
        button.addEventListener("click", function () {
            const cursoId = this.dataset.cursoId;
            const estadoAtual = parseInt(this.dataset.estado); // 1 ou 2

            // Alterna localmente
            const novoEstado = estadoAtual === 1 ? 2 : 1;
            this.dataset.estado = novoEstado;
            this.textContent = novoEstado === 1 ? "ativo" : "inativo";

            // Atualiza classes para CSS
            this.classList.remove("ativo", "inativo");
            this.classList.add(novoEstado === 1 ? "ativo" : "inativo");

            // Envia para backend
            fetch(`/cursos/${cursoId}/toggle-estado`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                body: JSON.stringify({ estado: novoEstado }),
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Erro ao atualizar no backend");
                    }
                    return response.json();
                })
                .then((data) => console.log("Atualizado:", data))
                .catch((err) => console.error("Falhou:", err));
        });
    });
});

//pesquisa
function enableSearch(inputId, gridId) {
    const input = document.getElementById(inputId);
    const grid = document.getElementById(gridId);
    if (!input || !grid) return;

    // Guarda os cards originais na ordem
    const allCards = Array.from(grid.children);

    input.addEventListener("input", function () {
        const query = this.value.toLowerCase();

        // Limpa o grid
        grid.innerHTML = "";

        if (query === "") {
            // Se input vazio → mostra tudo na ordem original
            allCards.forEach((c) => {
                c.style.display = "";
                grid.appendChild(c);
            });
            return;
        }

        // Filtra cards que batem
        const matching = allCards.filter((card) => {
            const titleEl = card.querySelector(".card-title");
            const nome = titleEl ? titleEl.textContent.toLowerCase() : "";
            return nome.includes(query);
        });

        // Mostra só os que batem, no topo
        matching.forEach((c) => {
            c.style.display = "";
            grid.appendChild(c);
        });
    });
}

document.addEventListener("DOMContentLoaded", () => {
    enableSearch("pesquisa-instituicao", "grid-instituicoes");
    enableSearch("pesquisa-cursos", "grid-cursos");
    enableSearch("pesquisa-modulos", "grid-modulos");
    enableSearch("pesquisa-documentos", "grid-documentos");
});



//Adicionar Cor
document.addEventListener("DOMContentLoaded", function () {
    const btnAdicionarCor = document.getElementById("btnAdicionarCor");
    const inputCor = document.getElementById("inputCor");
    const colorPreview = document.getElementById("colorPreview");

    // valor inicial do banco (se existir)
    if (inputCor.value) {
        colorPreview.style.backgroundColor = inputCor.value;
    }

    // abrir seletor ao clicar no botão
    btnAdicionarCor.addEventListener("click", function () {
        inputCor.click();
    });

    // atualizar o quadradinho ao escolher cor
    inputCor.addEventListener("input", function () {
        colorPreview.style.backgroundColor = inputCor.value;
    });
});

// Adicionar Cor nos modais de edição
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".btn-adicionar-cor").forEach((btn) => {
        const id = btn.id.split("-")[1]; // pega o ID da instituição
        const inputCor = document.getElementById(`inputCor-${id}`);
        const colorPreview = document.getElementById(`colorPreview-${id}`);

        // atualiza o quadradinho no carregamento
        if (inputCor && colorPreview) {
            colorPreview.style.backgroundColor = inputCor.value || "#f5f4f4";
        }

        // ao clicar, abre o seletor de cor
        btn.addEventListener("click", function () {
            if (inputCor) inputCor.click();
        });

        // ao escolher cor, atualiza o quadradinho
        if (inputCor && colorPreview) {
            inputCor.addEventListener("input", function () {
                colorPreview.style.backgroundColor = inputCor.value;
            });
        }
    });
});


//documentos, link ou arquivo
const botoesTipo = document.querySelectorAll('.tipo-btn');
const hiddenTipo = document.getElementById('tipo_documento_hidden');
const selectOrigem = document.getElementById("origem_documento");
const campoArquivo = document.getElementById("campo-arquivo");
const campoLink = document.getElementById("campo-link");
const inputArquivo = document.getElementById("arquivo_documento");
const inputLink = document.getElementById("link_documento");
const vitalicioCheckbox = document.getElementById('vitalicio');
const validadeInput = document.getElementById('dataValidade');
const labelValidade = document.getElementById('labelValidade');

// Select origem documento
if(selectOrigem){
selectOrigem.addEventListener("change", function () {
    toggleRequired();
    aplicarRegraVitalicio();
});
}
function toggleRequired() {
    if (selectOrigem.value === "arquivo") {
        campoArquivo.classList.remove("d-none");
        campoLink.classList.add("d-none");

        inputArquivo.required = true;
        inputLink.required = false;
        inputLink.value = "";
    } else {
        campoArquivo.classList.add("d-none");
        campoLink.classList.remove("d-none");

        inputArquivo.required = false;
        inputLink.required = true;
        inputArquivo.value = "";
    }
}

function esconderValidade() {
    validadeInput.hidden = true;
    labelValidade.hidden = true;
}

function mostrarValidade() {
    validadeInput.hidden = false;
    labelValidade.hidden = false;
}

function aplicarRegraVitalicio() {
    const tipo = hiddenTipo.value; // pessoal ou apoio
    const origem = selectOrigem.value; //arquivo ou link

    if (tipo === "pessoal" && origem === "link") {
        vitalicioCheckbox.checked = true;
        validadeInput.value = "9999-01-01";
        esconderValidade();

    } else if (tipo === "pessoal" && origem === "arquivo") {
        vitalicioCheckbox.checked = false;
        validadeInput.value = "";
        mostrarValidade();
    }
}

// Botões tipo documento
botoesTipo.forEach(btn => {
    btn.addEventListener('click', function () {
        botoesTipo.forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        const tipo = this.getAttribute('data-tipo'); // pessoal ou apoio
        hiddenTipo.value = tipo;

        // alternar forms
        document.querySelectorAll('.form-tipo').forEach(f => f.style.display = 'none');
        document.getElementById('form-' + tipo).style.display = 'block';

        // validade obrigatória só no pessoal
        if (tipo === 'pessoal') {
            validadeInput.setAttribute('required', true);
        } else {
            validadeInput.removeAttribute('required');
        }

        aplicarRegraVitalicio();
    });
});

// Checkbox vitalício manual
if(vitalicioCheckbox){
vitalicioCheckbox.addEventListener('change', () => {
    if (vitalicioCheckbox.checked) {
        validadeInput.value = '9999-01-01';
        esconderValidade();
    } else {
        validadeInput.value = '';
        mostrarValidade();
    }
});
}
//Documento com data para expirar
document.addEventListener("DOMContentLoaded", function () {
    const hoje = new Date();

    document.querySelectorAll(".validade-doc").forEach(function (el) {
        const validadeStr = el.dataset.validade;
        if (!validadeStr) return;

        const validade = new Date(validadeStr);
        const diffDias = Math.ceil((validade - hoje) / (1000 * 60 * 60 * 24));

        if (validade < hoje) {
            el.innerHTML = `<i class="bi bi-x-circle text-danger"></i> Expirado em ${validade.toLocaleDateString("pt-PT")}`;
        } else if (diffDias <= 30) {
            el.innerHTML = `<i class="bi bi-exclamation-triangle text-warning"></i> Por expirar em ${validade.toLocaleDateString("pt-PT")}`;
        } else {
            el.innerHTML = `<i class="bi bi-clock text-success"></i> Expira em ${validade.toLocaleDateString("pt-PT")}`;
        }
    });
});

//exportar
if(document.getElementById('exportarSelecionados')){
document.getElementById('exportarSelecionados').addEventListener('click', async () => {
    const checkboxes = document.querySelectorAll('.pdfSelect:checked');
    if (checkboxes.length === 0) return alert('Selecione ao menos um PDF!');

    const mergedPdf = await PDFLib.PDFDocument.create();

    for (let cb of checkboxes) {
        const url = cb.dataset.url;
        const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer());
        const pdf = await PDFLib.PDFDocument.load(existingPdfBytes);
        const copiedPages = await mergedPdf.copyPages(pdf, pdf.getPageIndices());
        copiedPages.forEach(page => mergedPdf.addPage(page));
    }

    const mergedPdfFile = await mergedPdf.save();
    const blob = new Blob([mergedPdfFile], { type: 'application/pdf' });

    // Cria link para download
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'documentos_unificados.pdf';
    link.click();
});
}


//input photo
document.addEventListener('DOMContentLoaded', function() {
    const btnAddFoto = document.getElementById('btnAddFoto');
    const inputFoto = document.getElementById('inputFoto');

    btnAddFoto.addEventListener("click", function () {
        // Alterna entre mostrar/esconder
        inputFoto.classList.toggle('d-none');
        // Se estiver visível, abre o seletor automaticamente
        if (!inputFoto.classList.contains('d-none')) {
            inputFoto.click();
        }
    });
});







//imagem no modal
document.querySelector('.profile img').addEventListener('click', function() {
    var myModal = new bootstrap.Modal(document.getElementById('novoUserModal'));
    myModal.show();
});

//check modulos
// remove o required se algum for marcado
document.querySelectorAll('input[name="cursos[]"]').forEach(input => {
    input.addEventListener('change', () => {
        let checked = document.querySelectorAll('input[name="cursos[]"]:checked').length > 0;
        document.querySelectorAll('input[name="cursos[]"]')[0].required = !checked;
    });
});


