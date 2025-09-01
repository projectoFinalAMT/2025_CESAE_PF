//Aparecer Botão Selecionado
document.addEventListener("DOMContentLoaded", () => {
    const apagarBtn = document.getElementById('apagarSelecionados');
    const checkboxes = document.querySelectorAll('.card-cursos .form-check-input');

    checkboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            // Mostrar botão se pelo menos 1 checkbox estiver marcado
            const algumSelecionado = Array.from(checkboxes).some(c => c.checked);
            apagarBtn.style.display = algumSelecionado ? 'inline-block' : 'none';
        });
    });
});

//formulario Doc
document.addEventListener("DOMContentLoaded", () => {
    const botoesTipo = document.querySelectorAll(".tipo-btn");
    const formularios = document.querySelectorAll(".form-tipo");

    botoesTipo.forEach(botao => {
        botao.addEventListener("click", () => {
            // remover "active" de todos os botões e ativar o clicado
            botoesTipo.forEach(b => b.classList.remove("active"));
            botao.classList.add("active");

            // esconder todos os formulários
            formularios.forEach(f => f.style.display = "none");

            // mostrar só o formulário correspondente ao botão clicado
            const tipo = botao.getAttribute("data-tipo");
            document.getElementById("form-" + tipo).style.display = "block";
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const confirmarEliminarModal = document.getElementById('confirmarEliminar');
    const formEliminar = document.getElementById('formEliminar');

    // Quando o modal abrir via botão, preenche o id do botão (single delete)
    confirmarEliminarModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');

        // Só preenche se o botão tiver data-id
        if(id) {
            document.getElementById('idsSelecionados').value = id;
        }
    });

    // Quando o form for submetido, pega os checkboxes (multi delete)
    formEliminar.addEventListener('submit', function(e) {
        // Para cursos
        const checkboxesCursos = document.querySelectorAll('input[name="cursos[]"]:checked');
        const idsCursos = Array.from(checkboxesCursos).map(cb => cb.value);

        // Para instituições
        const checkboxesInst = document.querySelectorAll('input[name="instituicoes[]"]:checked');
        const idsInst = Array.from(checkboxesInst).map(cb => cb.value);

        // Decide quais IDs enviar (checkboxes têm prioridade se existirem)
        const ids = idsCursos.length ? idsCursos : idsInst;

        if(ids.length > 0) {
            document.getElementById('idsSelecionados').value = ids.join(',');
        }
        // Se não houver checkboxes marcados e data-id já estiver preenchido, mantém
    });
});

//tempo post sucess
document.addEventListener('DOMContentLoaded', function () {
    const toastEl = document.getElementById('successToast');
    if(toastEl){
        const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
        toast.show();
    }
});

//mudar botao Ativo/Inativo
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.status-btn');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const cursoId = this.dataset.cursoId;
            const estadoAtual = parseInt(this.dataset.estado);

            // Alterna localmente
            const novoEstado = estadoAtual === 1 ? 2 : 1;
            this.dataset.estado = novoEstado;
            this.textContent = novoEstado === 1 ? 'ativo' : 'inativo';
            this.classList.toggle('ativo', novoEstado === 1);
            this.classList.toggle('inativo', novoEstado === 2);

            // Atualiza no backend
            fetch(`/cursos/${cursoId}/toggle-estado`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ estado: novoEstado })
            })
            .catch(err => console.error(err));
        });
    });
});

