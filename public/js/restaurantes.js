// Menú hamburguesa para móvil
window.onload = function() {
    const btnMenu = document.querySelector('.btn-menu-detalle');
    const tabsNav = document.querySelector('.tabs-nav');
    
    if (btnMenu && tabsNav) {
        btnMenu.onclick = function() {
            tabsNav.classList.toggle('show');
            btnMenu.classList.toggle('active');
        };
        
        // Cerrar el menú al hacer clic en un enlace
        const navLinks = tabsNav.querySelectorAll('.nav-link');
        navLinks.forEach(function(link) {
            link.onclick = function() {
                if (window.innerWidth <= 768) {
                    tabsNav.classList.remove('show');
                    btnMenu.classList.remove('active');
                }
            };
        });
        
        // Cerrar el menú al hacer clic fuera de él
        document.onclick = function(event) {
            if (window.innerWidth <= 768) {
                const isClickInsideMenu = tabsNav.contains(event.target);
                const isClickOnButton = btnMenu.contains(event.target);
                
                if (!isClickInsideMenu && !isClickOnButton && tabsNav.classList.contains('show')) {
                    tabsNav.classList.remove('show');
                    btnMenu.classList.remove('active');
                }
            }
        };
    }

    // Acordeón del sidebar de contenido relacionado en responsive
    const btnToggleSidebar = document.getElementById('btnToggleSidebar');
    const sidebarContent = document.getElementById('sidebarContent');
    
    if (btnToggleSidebar && sidebarContent) {
        btnToggleSidebar.onclick = function() {
            sidebarContent.classList.toggle('show');
            btnToggleSidebar.classList.toggle('active');
        };
    }
};

// Funcionalidad para la página de restaurantes
const searchInput = document.getElementById('restaurant-search-input');
const searchButton = document.getElementById('restaurant-search-button');
const clearButton = document.getElementById('restaurant-search-clear');
const resultsGrid = document.getElementById('restaurants-grid');
const countLabel = document.getElementById('restaurantes-count');
const pagination = document.getElementById('restaurantes-pagination');
const searchUrl = document.body ? document.body.dataset.searchUrl : '';

const buildPriceLabel = (precio) => {
	if (precio < 30) {
		return '€';
	}
	if (precio < 60) {
		return '€€';
	}
	if (precio < 100) {
		return '€€€';
	}
	return '€€€€';
};

const buildSoles = (soles) => {
	let icons = '';
	for (let i = 0; i < soles; i += 1) {
		icons += '<i class="bi bi-sun-fill sun-icon"></i>';
	}
	return icons;
};

const renderCards = (items) => {
	if (!resultsGrid) {
		return;
	}

	if (!items || items.length === 0) {
		resultsGrid.innerHTML = '<div class="col-12"><p class="text-center text-muted">No se encontraron restaurantes.</p></div>';
		return;
	}

	const html = items.map((item) => {
		const soles = Number(item.soles || 0);
		const ratingHtml = soles > 0
			? `${buildSoles(soles)}<span>${soles} ${soles === 1 ? 'Sol' : 'Soles'}</span>`
			: `<i class="bi bi-star-fill"></i><span>${item.valoracion}</span>`;

		const priceLabel = buildPriceLabel(Number(item.precio || 0));

		return `
			<div class="col-md-4">
				<a href="${item.detalle_url}" class="text-decoration-none">
					<div class="card restaurant-card">
						<img src="${item.imagen}" class="card-img-top" alt="${item.nombre}">
						<div class="card-body">
							<h5 class="card-title">${item.nombre}</h5>
							<p class="card-text">
								<i class="bi bi-geo-alt"></i> ${item.categoria} · ${item.ciudad}, ${item.provincia}
							</p>
							<div class="rating">
								${ratingHtml}
								<span class="badge-stars">${priceLabel}</span>
							</div>
						</div>
					</div>
				</a>
			</div>
		`;
	}).join('');

	resultsGrid.innerHTML = html;
};

const updateCount = (total, term) => {
	if (!countLabel) {
		return;
	}

	if (term) {
		countLabel.textContent = `${total} resultados para "${term}"`;
	} else {
		countLabel.textContent = `${total} resultados para *`;
	}
};

const updatePagination = (data) => {
	if (!pagination) {
		return;
	}

	// Si no hay páginas o solo hay una página, ocultar la paginación
	if (!data.last_page || data.last_page <= 1) {
		pagination.innerHTML = '';
		return;
	}

	const currentPage = data.current_page || 1;
	const lastPage = data.last_page || 1;

	// Construir HTML de la paginación
	let paginationHtml = '<div class="d-flex justify-content-center align-items-center gap-3">';
	
	// Flecha Anterior
	if (currentPage === 1) {
		paginationHtml += `
			<span class="pagination-arrow disabled">
				<i class="bi bi-chevron-left" style="font-size: 60px; color: #333;"></i>
			</span>
		`;
	} else {
		paginationHtml += `
			<a href="#" class="pagination-arrow" data-page="${currentPage - 1}">
				<i class="bi bi-chevron-left" style="font-size: 60px; color: #333;"></i>
			</a>
		`;
	}

	// Números de página
	paginationHtml += '<div class="d-flex gap-2">';
	for (let page = 1; page <= lastPage; page++) {
		if (page === currentPage) {
			paginationHtml += `<span class="page-number active">${page}</span>`;
		} else {
			paginationHtml += `<a href="#" class="page-number" data-page="${page}">${page}</a>`;
		}
	}
	paginationHtml += '</div>';

	// Flecha Siguiente
	if (currentPage === lastPage) {
		paginationHtml += `
			<span class="pagination-arrow disabled">
				<i class="bi bi-chevron-right" style="font-size: 60px; color: #ccc;"></i>
			</span>
		`;
	} else {
		paginationHtml += `
			<a href="#" class="pagination-arrow" data-page="${currentPage + 1}">
				<i class="bi bi-chevron-right" style="font-size: 60px; color: #00a3e0;"></i>
			</a>
		`;
	}

	paginationHtml += '</div>';

	pagination.innerHTML = paginationHtml;

	// Añadir eventos onclick a los enlaces de paginación
	const pageLinks = pagination.querySelectorAll('a[data-page]');
	pageLinks.forEach(function(link) {
		link.onclick = function(e) {
			e.preventDefault();
			const pageNum = this.getAttribute('data-page');
			fetchResultsPage(searchInput ? searchInput.value.trim() : '', pageNum);
		};
	});
};

const fetchResults = (term) => {
	if (!searchUrl) {
		return;
	}

	const url = `${searchUrl}?buscar=${encodeURIComponent(term)}`;
	fetch(url, {
		headers: {
			'X-Requested-With': 'XMLHttpRequest'
		}
	})
		.then((response) => response.json())
		.then((data) => {
			renderCards(data.items);
			updateCount(data.total, data.term);
			updatePagination(data);
		});
};

const fetchResultsPage = (term, page) => {
	if (!searchUrl) {
		return;
	}

	const url = `${searchUrl}?buscar=${encodeURIComponent(term)}&page=${page}`;
	fetch(url, {
		headers: {
			'X-Requested-With': 'XMLHttpRequest'
		}
	})
		.then((response) => response.json())
		.then((data) => {
			renderCards(data.items);
			updateCount(data.total, data.term);
			updatePagination(data);
			// Scroll suave hacia arriba
			window.scrollTo({ top: 0, behavior: 'smooth' });
		});
};

if (searchInput) {
	searchInput.oninput = function () {
		fetchResults(this.value.trim());
	};
}

if (searchButton) {
	searchButton.onclick = function () {
		const term = searchInput ? searchInput.value.trim() : '';
		fetchResults(term);
	};
}

if (clearButton) {
	clearButton.onclick = function () {
		if (searchInput) {
			searchInput.value = '';
		}
		fetchResults('');
	};
}