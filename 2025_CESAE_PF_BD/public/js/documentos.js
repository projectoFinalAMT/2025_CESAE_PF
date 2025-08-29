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

