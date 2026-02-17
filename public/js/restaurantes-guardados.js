// Menú hamburguesa para móvil
window.onload = function() {
    const btnMenu = document.querySelector('.btn-menu-detalle');
    const mobileMenu = document.getElementById('mobileMenu');
    
    if (btnMenu && mobileMenu) {
        btnMenu.onclick = function() {
            if (typeof toggleMobileMenu === 'function') {
                toggleMobileMenu();
            } else {
                mobileMenu.classList.toggle('active');
            }
            btnMenu.classList.toggle('active');
        };
        
        // Cerrar el menú al hacer clic en un enlace
        const navLinks = mobileMenu.querySelectorAll('a');
        navLinks.forEach(function(link) {
            link.onclick = function() {
                if (window.innerWidth <= 768) {
                    mobileMenu.classList.remove('active');
                    btnMenu.classList.remove('active');
                }
            };
        });
        
        // Cerrar el menú al hacer clic fuera de él
        document.onclick = function(event) {
            if (window.innerWidth <= 768) {
                const isClickInsideMenu = mobileMenu.contains(event.target);
                const isClickOnButton = btnMenu.contains(event.target);
                
                if (!isClickInsideMenu && !isClickOnButton && mobileMenu.classList.contains('active')) {
                    mobileMenu.classList.remove('active');
                    btnMenu.classList.remove('active');
                }
            }
        };
    }
};

// Inicializar menú móvil
initializeMobileMenu();
