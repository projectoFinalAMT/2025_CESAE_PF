
document.addEventListener('DOMContentLoaded', () => {
  const selInst   = document.getElementById('instituicao_ids');
  const selCurso  = document.getElementById('curso_ids');
  const selModulo = document.getElementById('modulo_ids');

  const values = (sel) => Array.from(sel?.selectedOptions || []).map(o => o.value);

  function resetSelect(selectEl, placeholder = null) {
    if (!selectEl) return;
    selectEl.innerHTML = '';
    if (placeholder) {
      const opt = document.createElement('option');
      opt.disabled = true; opt.textContent = placeholder;
      selectEl.appendChild(opt);
    }
    selectEl.disabled = true;
  }

  function enableIfHasOptions(selectEl) {
    if (!selectEl) return;
    selectEl.disabled = selectEl.options.length === 0;
  }

  // Carrega cursos para um array de instituições (merge de resultados)
  async function loadCursosByInsts(instIds) {
    resetSelect(selCurso);
    resetSelect(selModulo);

    if (!instIds || instIds.length === 0) return;

    const vistos = new Set();

    for (const id of instIds) {
      try {
        const res = await fetch(`/instituicoes/${id}/cursos`, { headers: { 'Accept': 'application/json' }});
        if (!res.ok) throw new Error('Falha ao carregar cursos.');
        const cursos = await res.json(); // [{id, titulo}, ...]
        cursos.forEach(c => {
          if (vistos.has(c.id)) return;
          vistos.add(c.id);
          const o = document.createElement('option');
          o.value = c.id;
          o.textContent = c.titulo ?? c.nome ?? `Curso #${c.id}`;
          selCurso.appendChild(o);
        });
      } catch (e) {
        console.error(e);
        alert(e.message || 'Erro a carregar cursos.');
      }
    }

    enableIfHasOptions(selCurso);
  }

  // Carrega módulos para um array de cursos (merge de resultados)
  async function loadModulosByCursos(cursoIds) {
    resetSelect(selModulo);

    if (!cursoIds || cursoIds.length === 0) return;

    const vistos = new Set();

    for (const id of cursoIds) {
      try {
        const res = await fetch(`/cursos/${id}/modulos`, { headers: { 'Accept': 'application/json' }});
        if (!res.ok) throw new Error('Falha ao carregar módulos.');
        const modulos = await res.json(); // [{id, nomeModulo}, ...]
        modulos.forEach(m => {
          if (vistos.has(m.id)) return;
          vistos.add(m.id);
          const o = document.createElement('option');
          o.value = m.id;
          o.textContent = m.nomeModulo ?? `Módulo #${m.id}`;
          selModulo.appendChild(o);
        });
      } catch (e) {
        console.error(e);
        alert(e.message || 'Erro a carregar módulos.');
      }
    }

    enableIfHasOptions(selModulo);
  }

  // Eventos
  selInst?.addEventListener('change', () => loadCursosByInsts(values(selInst)));
  selCurso?.addEventListener('change', () => loadModulosByCursos(values(selCurso)));

  // Ao abrir o modal, limpa dependentes
  const modalEl = document.getElementById('alunoModal');
  modalEl?.addEventListener('show.bs.modal', () => {
    resetSelect(selCurso);
    resetSelect(selModulo);
  });
});



// calculo das medias na tabela alunos
function calculomedia(){



const avaliacoes = document.querySelectorAll('input[type="number"]');
let divisor=0;
let soma=0;

console.log(avaliacoes)


for(let avaliacao of avaliacoes){

let valor = parseFloat(avaliacao.value);

if (!isNaN(valor)){
    soma += valor
    divisor++
}
}
let media= (soma/divisor).toFixed(2)

//colocar a media na coluna da media
let mediaDoAluno= document.querySelector('.mediaAluno');
mediaDoAluno.value=media
}



//modal alunos
document.addEventListener('DOMContentLoaded', function () {
  const modalEl = document.getElementById('infoAlunoModal');

  modalEl.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget; // botão que abriu o modal

    // Ler atributos data-*
    const id    = button.getAttribute('data-id');
    const nome  = button.getAttribute('data-nome') || '';
    const email = button.getAttribute('data-email') || '';
    const tel   = button.getAttribute('data-telefone') || '';
    const obs   = button.getAttribute('data-observacoes') || '';

    // Preencher campos do modal
    modalEl.querySelector('#aluno_id').value = id;
    modalEl.querySelector('#nome').value = nome;
    modalEl.querySelector('#email').value = email;
    modalEl.querySelector('#telefone').value = tel;
    modalEl.querySelector('#observacoes').value = obs;
    modalEl.querySelector('#alunoNomeHeader').textContent = nome;

    const form = modalEl.querySelector('#formInfoAluno');


  });


});


//barra de pesquisar aluno

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
    enableSearch("pesquisaAluno","gridAlunos");


});





document.addEventListener("DOMContentLoaded", () => {
    const btnAdd = document.getElementById("addEval");
    const btnRemove = document.getElementById("removeEval");

    const table = document.getElementById("tabelaAlunos");
    const thead = table.querySelector("thead");
    const tbody = document.getElementById("gridAlunos");

    const thMedia = document.getElementById("th-media");
    const tplTh = document.getElementById("tpl-eval-th");
    const tplTd = document.getElementById("tpl-eval-td");

    const MAX_EVALS = 4; // 1 fixa + até 3 dinâmicas
    const MIN_EVALS = 1;
    const STORAGE_COUNT_KEY = "avaliacoes_qtd";
    const STORAGE_VALS_KEY = "avaliacoes_valores";

    // Helpers
    const getEvalThs = () => [...thead.querySelectorAll(".th-avaliacao")];
    const getDynEvalThs = () => [...thead.querySelectorAll(".th-avaliacao-dyn")];

    const saveCount = (n) => localStorage.setItem(STORAGE_COUNT_KEY, String(n));
    const loadCount = () => {
      const n = parseInt(localStorage.getItem(STORAGE_COUNT_KEY), 10);
      if (Number.isNaN(n)) return MIN_EVALS;
      return Math.min(Math.max(n, MIN_EVALS), MAX_EVALS);
    };

    function reindexHeaders() {
      const allThs = getEvalThs();
      allThs.forEach((th, idx) => {
        if (idx === 0) return; // mantém Avaliação 1
        const span = th.querySelector(".eval-index");
        if (span) span.textContent = String(idx + 1);
        else th.textContent = `Avaliação ${idx + 1}`;
      });
    }

    function addEvalColumn({ silent = false } = {}) {
      const current = getEvalThs().length;
      if (current >= MAX_EVALS) return;

      const thFrag = tplTh.content.cloneNode(true);
      thMedia.before(thFrag);

      tbody.querySelectorAll("tr").forEach((tr) => {
        const tdFrag = tplTd.content.cloneNode(true);
        const input = tdFrag.querySelector("input");
        const alunoId = tr.getAttribute("data-aluno-id");
        if (alunoId && input) {
          input.name = `avaliacoes[${alunoId}][]`;
        }
        const tdMedia = tr.querySelector(".td-media");
        tdMedia.before(tdFrag);
      });

      reindexHeaders();
      attachSaveListeners();

      if (!silent) saveCount(current + 1);
    }

    function removeEvalColumn({ silent = false } = {}) {
      const current = getEvalThs().length;
      if (current <= MIN_EVALS) return;

      const lastDynTh = getDynEvalThs().pop();
      if (lastDynTh) lastDynTh.remove();

      tbody.querySelectorAll("tr").forEach((tr) => {
        const evalTds = tr.querySelectorAll(".td-avaliacao");
        const lastTd = evalTds[evalTds.length - 1];
        if (lastTd && lastTd.classList.contains("td-avaliacao-dyn")) {
            const input = lastTd.querySelector("input");
            if (input) input.value = "";
            const alunoId = tr.getAttribute("data-aluno-id");
            const evalIndex = evalTds.length; // índice da última avaliação
            const key = makeKey(alunoId, evalIndex);

            const allVals = loadAvaliacoes();
            delete allVals[key];
            saveAvaliacoes(allVals);
          lastTd.remove();
        }
      });

      reindexHeaders();
      attachSaveListeners();

      if (!silent) saveCount(current - 1);
    }

    function restoreColumnsFromStorage() {
      const desired = loadCount();
      let current = getEvalThs().length;
      while (current < desired) {
        addEvalColumn({ silent: true });
        current++;
      }
      while (current > desired) {
        removeEvalColumn({ silent: true });

        current--;
        //limpar o imput
      }
      saveCount(current);
      reindexHeaders();
    }

    // ---------- Guardar valores dos inputs ----------
    function loadAvaliacoes() {
      const data = localStorage.getItem(STORAGE_VALS_KEY);
      return data ? JSON.parse(data) : {};
    }

    function saveAvaliacoes(obj) {
      localStorage.setItem(STORAGE_VALS_KEY, JSON.stringify(obj));
    }

    function makeKey(alunoId, evalIndex) {
      return `${alunoId}_${evalIndex}`;
    }

    function attachSaveListeners() {
      document.querySelectorAll(".input-avaliacao").forEach((input) => {
        const tr = input.closest("tr");
        const alunoId = tr?.getAttribute("data-aluno-id") || "na";
        const evalIndex =
          Array.from(tr.querySelectorAll(".input-avaliacao")).indexOf(input) + 1;
        const key = makeKey(alunoId, evalIndex);

        // restaurar valor salvo
        const saved = loadAvaliacoes()[key];
        if (saved !== undefined) {
          input.value = saved;
        }

        // guardar ao escrever
        input.oninput = () => {
          const allVals = loadAvaliacoes();
          allVals[key] = input.value;
          saveAvaliacoes(allVals);
        };
      });
    }

    // ---------- Inicialização ----------
    btnAdd?.addEventListener("click", () => addEvalColumn());
    btnRemove?.addEventListener("click", () => removeEvalColumn());

    restoreColumnsFromStorage();
    attachSaveListeners();
  });





// ======== Cálculo de médias e envio ao servidor ========
function setupAtualizarMedias() {
    const btn = document.getElementById("btnAtualizar");
    if (!btn) {                      // <-- proteção caso o botão não exista ainda
      console.warn("btnAtualizar não encontrado no DOM");
      return;
    }

    function parseNumber(val) {
      if (val === null || val === undefined) return NaN;
      return Number(String(val).replace(",", "."));
    }

    btn.addEventListener("click", async () => {
      const tbody = document.getElementById("gridAlunos");
      const rows = tbody.querySelectorAll("tr");

      const mediasPayload = {};
      rows.forEach((tr) => {
        const alunoId = tr.getAttribute("data-aluno-id");
        if (!alunoId) return;

        const inputs = tr.querySelectorAll(".input-avaliacao");
        const nums = Array.from(inputs)
          .map((i) => parseNumber(i.value))
          .filter((n) => !Number.isNaN(n));

        if (nums.length === 0) return;

        const media = nums.reduce((a, b) => a + b, 0) / nums.length;

        const tdMedia = tr.querySelector(".td-media");
        if (tdMedia) tdMedia.textContent = media.toFixed(2);

        mediasPayload[alunoId] = media;
      });

      if (Object.keys(mediasPayload).length === 0) return;

      try {
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");
        const res = await fetch("/alunos/medias", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrf || "",
            "Accept": "application/json",
          },
          body: JSON.stringify({ medias: mediasPayload }),
        });

        if (!res.ok) {
          console.error("Erro ao atualizar médias", await res.text());
          return;
        }
        window.location.reload();
      } catch (err) {
        console.error("Falha na atualização de médias:", err);
      }
    });
  }

  // *** CHAMAR a função quando o DOM estiver pronto ***
  document.addEventListener("DOMContentLoaded", setupAtualizarMedias);


  //tempo post sucess
document.addEventListener("DOMContentLoaded", function () {
    const toastEl = document.getElementById("successToast");
    if (toastEl) {
        const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
        toast.show();
    }
});

// --------- Filtro por Módulos ---------
function setupModuloFilter() {
    const menu = document.getElementById("filterDropdownModulos");
    const btn  = document.getElementById("btnFilterModulos");
    if (!menu || !btn) {
      console.warn("[modulos] menu ou botão não encontrados");
      return;
    }

    const selected = new Set();

    function applyFilter() {
      const rows = document.querySelectorAll("#gridAlunos tr");
      if (selected.size === 0) {
        rows.forEach(r => r.style.display = "");
        updateBadge(0);
        return;
      }
      rows.forEach(r => {
        const mid = String(r.dataset.moduloId || "");
        r.style.display = selected.has(mid) ? "" : "none";
      });
      updateBadge(selected.size);
    }

    function updateBadge(n) {
      let badge = btn.querySelector(".filter-badge");
      if (n > 0) {
        if (!badge) {
          badge = document.createElement("span");
          badge.className = "badge rounded-pill text-bg-secondary ms-2 filter-badge";
          btn.appendChild(badge);
        }
        badge.textContent = n;
      } else if (badge) {
        badge.remove();
      }
    }

    menu.addEventListener("click", (e) => {
      const a = e.target.closest("a");
      if (!a) return;
      e.preventDefault();
      e.stopPropagation();

      if (a.dataset.clear) {
        selected.clear();
        menu.querySelectorAll("a[data-modulo-id].active").forEach(el => el.classList.remove("active"));
        applyFilter();
        return;
      }

      const id = String(a.dataset.moduloId || "");
      if (!id) return;

      if (selected.has(id)) {
        selected.delete(id);
        a.classList.remove("active");
      } else {
        selected.add(id);
        a.classList.add("active");
      }
      applyFilter();
    });

    console.log("[modulos] pronto. Exemplo 1ª linha moduloId:",
      (document.querySelector("#gridAlunos tr")?.dataset?.moduloId) || "(sem linhas)");
  }

  // chama quando o DOM estiver carregado
  document.addEventListener("DOMContentLoaded", setupModuloFilter);





