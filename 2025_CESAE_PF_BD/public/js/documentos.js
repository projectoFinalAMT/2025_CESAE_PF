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
    const idsSelecionados = document.getElementById('idsSelecionados');

    // Single delete via data-id
    confirmarEliminarModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        if(id) {
            idsSelecionados.value = id;
        }
    });

    // Multi delete (cursos, instituições, módulos)
    formEliminar.addEventListener('submit', function(e) {
        // Cursos
        const checkboxesCursos = document.querySelectorAll('input[name="cursos[]"]:checked');
        const idsCursos = Array.from(checkboxesCursos).map(cb => cb.value);

        // Instituições
        const checkboxesInst = document.querySelectorAll('input[name="instituicoes[]"]:checked');
        const idsInst = Array.from(checkboxesInst).map(cb => cb.value);

        // Módulos (novo)
        const checkboxesModulos = document.querySelectorAll('input[name="modulos[]"]:checked');
        const idsModulos = Array.from(checkboxesModulos).map(cb => cb.value);

        // Prioridade: cursos > instituições > módulos
        let ids = [];
        if(idsCursos.length) {
            ids = idsCursos;
        } else if(idsInst.length) {
            ids = idsInst;
        } else if(idsModulos.length) {
            ids = idsModulos;
        }

        if(ids.length) {
            idsSelecionados.value = ids.join(',');
        }

        // Se não houver nenhum selecionado e hidden vazio
        if(!ids.length && !idsSelecionados.value) {
            e.preventDefault();
            alert('Selecione pelo menos um item para deletar.');
        }
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
            const estadoAtual = parseInt(this.dataset.estado); // 1 ou 2

            // Alterna localmente
            const novoEstado = estadoAtual === 1 ? 2 : 1;
            this.dataset.estado = novoEstado;
            this.textContent = novoEstado === 1 ? 'ativo' : 'inativo';

            // Atualiza classes para CSS
            this.classList.remove('ativo', 'inativo');
            this.classList.add(novoEstado === 1 ? 'ativo' : 'inativo');

            // Envia para backend
            fetch(`/cursos/${cursoId}/toggle-estado`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ estado: novoEstado })
            }).catch(err => console.error(err));
        });
    });
});

//pesquisa

document.addEventListener('DOMContentLoaded', () => {
   let myfilter= document.querySelector('input').getAttribute('id');
    search(myfilter);
});


function search(filter){
    const input = document.getElementById(filter);
    const cards = document.querySelectorAll('.row.g-4 > .col-12');

    input.addEventListener('input', function() {
        const query = this.value.toLowerCase();

        cards.forEach(card => {
            const nome = card.querySelector('.card-title').textContent.toLowerCase();
            if (nome.includes(query)) {
                card.style.display = ''; // mostra
            } else {
                card.style.display = 'none'; // esconde
            }
        });
    });
}

 // Previne o dropdown de fechar ao clicar nos checkboxes
  document.querySelectorAll('.curso-checkbox').forEach(function(checkbox) {
    checkbox.addEventListener('click', function(event) {
      event.stopPropagation();
    });
  });


