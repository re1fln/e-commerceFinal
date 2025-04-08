// Funcionalidad básica del carrito
document.addEventListener('DOMContentLoaded', function() {
    // Actualizar cantidad en el carrito
    const updateCartButtons = document.querySelectorAll('.update-cart');
    
    updateCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.id;
            const quantity = document.querySelector(`#quantity-${productId}`).value;
            
            // Aquí podrías hacer una petición AJAX para actualizar el carrito
            console.log(`Actualizar producto ${productId} a cantidad ${quantity}`);
        });
    });
    
    // Mostrar mensajes temporales
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.add('fade-out');
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
    
    // Tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Efecto fade-out para CSS
const style = document.createElement('style');
style.innerHTML = `
.fade-out {
    opacity: 1;
    transition: opacity 0.5s ease-out;
}
.fade-out.hide {
    opacity: 0;
}
`;
document.head.appendChild(style);