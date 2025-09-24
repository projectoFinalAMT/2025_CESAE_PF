
// Filtro de pesquisa do calendário
document.addEventListener('DOMContentLoaded', () => {
    const subtitle = document.getElementById('subtitle');
    const dropdownItems = document.querySelectorAll('#filterDropdown .dropdown-item');

    dropdownItems.forEach(item => {
      item.addEventListener('click', (e) => {
        e.preventDefault(); // evita o reload
        const valor = item.textContent.trim();
        subtitle.textContent = valor; // muda o subtitle
      });
    });
  });





