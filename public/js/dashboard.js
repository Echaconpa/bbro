// public/js/dashboard.js

document.addEventListener('DOMContentLoaded', function() {
    // Inicialización de widgets con datos estáticos de ejemplo
    initWidgets();

    // Agregar event listeners a los elementos que necesiten interacción
    setupEventListeners();
});

// Función para inicializar widgets
function initWidgets() {
    // Aquí podrías realizar llamadas a una API o base de datos para obtener datos dinámicos
    const widgetsData = {
        revenue: '$34,152',
        orders: 5643,
        customers: 45254,
        growth: '+12.58%'
    };

    // Asignar valores dinámicos a los widgets usando los IDs de cada uno
    document.querySelector('#widget-revenue p').innerText = widgetsData.revenue;
    document.querySelector('#widget-orders p').innerText = widgetsData.orders;
    document.querySelector('#widget-customers p').innerText = widgetsData.customers;
    document.querySelector('#widget-growth p').innerText = widgetsData.growth;
}

// Función para configurar event listeners
function setupEventListeners() {
    // Listener para el menú desplegable de usuario
    const userDropdown = document.getElementById('userDropdown');
    const dropdownMenu = document.getElementById('dropdownMenu');

    userDropdown.addEventListener('click', function() {
        dropdownMenu.classList.toggle('show'); // Mostrar/ocultar el menú desplegable
    });

    document.addEventListener('click', function(event) {
        if (!userDropdown.contains(event.target)) {
            dropdownMenu.classList.remove('show'); // Ocultar el menú si se hace clic fuera
        }
    });
}
