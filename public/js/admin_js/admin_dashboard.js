document.addEventListener('DOMContentLoaded', function() {
    var logoutBtn = document.querySelector('.logout-btn');

    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: '¿Cerrar sesión?',
                text: '¿Estás seguro de que quieres cerrar sesión?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: 'Sí, cerrar sesión',
                cancelButtonText: 'Cancelar'
            }).then(function(result) {
                if (result.isConfirmed) {
                    var logoutUrl = document.body.getAttribute('data-route-logout') || '/logout';
                    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch(logoutUrl, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        redirect: 'follow'
                    })
                    .then(function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sesión cerrada',
                            text: 'Hasta la próxima',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(function() {
                            window.location.href = '/';
                        });
                    })
                    .catch(function(error) {
                        console.error('Error al cerrar sesión:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al cerrar sesión'
                        }).then(function() {
                            window.location.href = '/';
                        });
                    });
                }
            });
        });
    }
});
