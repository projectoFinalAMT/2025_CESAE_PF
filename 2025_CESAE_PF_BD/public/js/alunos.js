


document.addEventListener('DOMContentLoaded', () => {
  const linhas = Array.from(document.querySelectorAll('#tabelaAlunos tbody tr'));
  const ddInst = document.getElementById('filterDropdownInst');
  const ddCurso = document.getElementById('filterDropdownCurs');
  const pesquisa = document.getElementById('pesquisaAlunos');
  const btnLimpar = document.getElementById('btnLimpar');

  const state = { inst: '', curso: '', q: '' };

  function aplica() {
    linhas.forEach(tr => {
      const inst = (tr.dataset.instituicao || '').toLowerCase();
      const curso = (tr.dataset.curso || '').toLowerCase();
      const nome = (tr.children[1]?.textContent || '').toLowerCase();
      const email = (tr.children[2]?.textContent || '').toLowerCase();

      const okInst = !state.inst || inst === state.inst;
      const okCurso = !state.curso || curso === state.curso;
      const okQ = !state.q || nome.includes(state.q) || email.includes(state.q);

      tr.style.display = (okInst && okCurso && okQ) ? '' : 'none';
    });
  }

  function handleMenuClick(menu, key, e) {
    const a = e.target.closest('a.dropdown-item');
    if (!a) return;
    e.preventDefault();

    // marcar ativo visualmente
    menu.querySelectorAll('.dropdown-item').forEach(i => i.classList.remove('active'));
    a.classList.add('active');

    // guardar estado (sempre em lowercase para comparar)
    state[key] = (a.dataset.valor || '').toLowerCase();
    aplica();
  }

  ddInst.addEventListener('click', (e) => handleMenuClick(ddInst, 'inst', e));
  ddCurso.addEventListener('click', (e) => handleMenuClick(ddCurso, 'curso', e));

  // pesquisa por nome/email
  const pesquisaInput = document.getElementById('pesquisaAlunos');
  if (pesquisaInput) {
    pesquisaInput.addEventListener('input', () => {
      state.q = pesquisaInput.value.toLowerCase().trim();
      aplica();
    });
  }

  btnLimpar.addEventListener('click', (e) => {
    e.preventDefault();
    state.inst = ''; state.curso = ''; state.q = '';
    if (pesquisaInput) pesquisaInput.value = '';

    // reset visual dos menus (primeiro item "Todas/Todos" fica active)
    [ddInst, ddCurso].forEach(menu => {
      const first = menu.querySelector('.dropdown-item');
      menu.querySelectorAll('.dropdown-item').forEach(i => i.classList.remove('active'));
      if (first) first.classList.add('active');
    });

    aplica();
  });

  aplica(); // inicial
});

