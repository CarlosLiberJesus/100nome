// Base de dados de recursos
let recursos = [];

// Carregar recursos do JSON
async function carregarRecursos() {
    try {
        const response = await fetch('recursos.json');
        recursos = await response.json();
        renderizarRecursos(recursos);
    } catch (error) {
        console.error('Erro ao carregar recursos:', error);
    }
}

// Renderizar recursos na página
function renderizarRecursos(recursosParaMostrar) {
    const container = document.getElementById('recursos-container');
    container.innerHTML = '';

    recursosParaMostrar.forEach(recurso => {
        const card = document.createElement('div');
        card.className = 'recurso-card';
        card.innerHTML = `
            <div class="icon">${recurso.icon}</div>
            <h3>${recurso.titulo}</h3>
            <p>${recurso.descricao}</p>
        `;
        card.addEventListener('click', () => abrirRecurso(recurso.arquivo));
        container.appendChild(card);
    });
}

// Abrir recurso (navegar para página HTML local)
function abrirRecurso(arquivo) {
    window.location.href = `recursos/${arquivo}`;
}

// Pesquisa
document.addEventListener('DOMContentLoaded', () => {
    carregarRecursos();

    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', (e) => {
        const termo = e.target.value.toLowerCase();
        const recursosFiltrados = recursos.filter(r => 
            r.titulo.toLowerCase().includes(termo) || 
            r.descricao.toLowerCase().includes(termo)
        );
        renderizarRecursos(recursosFiltrados);
    });
});