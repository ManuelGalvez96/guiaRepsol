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
};
