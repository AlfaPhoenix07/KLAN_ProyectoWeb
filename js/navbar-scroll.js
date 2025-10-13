// Script para cambiar el navbar al hacer scroll
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('nav.nav-wrapper');
    const logo = document.querySelector('nav .brand-logo img');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            // Agregar fondo al navbar
            navbar.classList.add('scrolled');
            
            // Contraer logo
            if (logo) {
                logo.style.height = '50px';
                logo.style.marginTop = '2px';
            }
        } else {
            // Quitar fondo del navbar
            navbar.classList.remove('scrolled');
            
            // Restaurar logo
            if (logo) {
                logo.style.height = '70px';
                logo.style.marginTop = '5px';
            }
        }
    });
});