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

            if(apagarBtn){ apagarBtn.style.display = algumSelecionado
                ? "inline-block"
                : "none";}

        });
    });
});

//formulario Doc
document.addEventListener("DOMContentLoaded", () => {
    const botoesTipo = document.querySelectorAll(".tipo-btn");
    const formularios = document.querySelectorAll(".form-tipo");

    botoesTipo.forEach((botao) => {
        botao.addEventListener("click", () => {
            // remover "active" de todos os botões e ativar o clicado
            botoesTipo.forEach((b) => b.classList.remove("active"));
            botao.classList.add("active");

            // esconder todos os formulários
            formularios.forEach((f) => (f.style.display = "none"));

            // mostrar só o formulário correspondente ao botão clicado
            const tipo = botao.getAttribute("data-tipo");
            document.getElementById("form-" + tipo).style.display = "block";
        });
    });
});


//Eliminar Card
document.addEventListener("DOMContentLoaded", function () {
    const confirmarEliminarModal = document.getElementById("confirmarEliminar");
    const formEliminar = document.getElementById("formEliminar");
    const idsSelecionados = document.getElementById("idsSelecionados");
    const cursoSelecionado = document.getElementById("cursoSelecionado"); // hidden input novo

    // Single delete via botão do card
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

    // Multi delete (cursos, instituições, módulos)
    formEliminar.addEventListener("submit", function (e) {
        const ids = [];

        // Cursos selecionados
        document.querySelectorAll('input[name="cursos[]"]:checked').forEach((cb) => ids.push(cb.value));

        // Instituições selecionadas
        document.querySelectorAll('input[name="instituicoes[]"]:checked').forEach((cb) => ids.push(cb.value));

        // Módulos selecionados
        document.querySelectorAll('input[name="modulos[]"]:checked').forEach((cb) => ids.push(cb.value));

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
});


//Aparecer Botão Selecionado Assiciado
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
    const btnApagarSelecionados = document.getElementById("apagarSelecionadosAssociados");
    const idsSelecionadosInput = document.getElementById("idsSelecionadosModulo");




    btnApagarSelecionados.addEventListener("click", function () {

        // Pega apenas checkboxes marcados
        const selecionados = Array.from(document.querySelectorAll('input[name="modulos[]"]:checked'))
                                  .map(cb => cb.dataset.cursoModuloId)
                                  .filter(id => id); // remove vazios

        if(selecionados.length === 0) {
            alert("Selecione pelo menos um módulo.");
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
            }).catch((err) => console.error(err));
        });
    });
});

//pesquisa

document.addEventListener("DOMContentLoaded", () => {
    let myfilter = document.querySelector("input").getAttribute("id");
    search(myfilter);
});

function search(filter) {
    const input = document.getElementById(filter);
    const cards = document.querySelectorAll(".row.g-4 > .col-12");

    input.addEventListener("input", function () {
        const query = this.value.toLowerCase();

        cards.forEach((card) => {
            const nome = card
                .querySelector(".card-title")
                .textContent.toLowerCase();
            if (nome.includes(query)) {
                card.style.display = ""; // mostra
            } else {
                card.style.display = "none"; // esconde
            }
        });
    });
}
