// public/js/sidebar.js
function toggleSidebar() {
    var sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("minimized");

    // Cambiar el ícono del menú hamburguesa según el estado de la barra lateral
    var toggleIcon = document.querySelector(".toggle-sidebar");
    if (sidebar.classList.contains("minimized")) {
        toggleIcon.textContent = "menu"; // Cambia a ícono de menú hamburguesa
    } else {
        toggleIcon.textContent = "menu_open"; // Cambia a ícono de menú abierto
    }

    // Cambiar el margen del contenido principal dinámicamente
    var mainContent = document.querySelector(".main-content");
    if (sidebar.classList.contains("minimized")) {
        mainContent.style.marginLeft = "80px";
        mainContent.style.width = "calc(100% - 80px)";
    } else {
        mainContent.style.marginLeft = "250px";
        mainContent.style.width = "calc(100% - 250px)";
    }

    // Guardar el estado en localStorage para que persista
    if (sidebar.classList.contains("minimized")) {
        localStorage.setItem("sidebarState", "minimized");
    } else {
        localStorage.setItem("sidebarState", "expanded");
    }
}

// Restaurar el estado de la barra lateral y el contenido al cargar la página
window.onload = function() {
    var sidebar = document.getElementById("sidebar");
    var sidebarState = localStorage.getItem("sidebarState");
    var toggleIcon = document.querySelector(".toggle-sidebar");
    var mainContent = document.querySelector(".main-content");

    if (sidebarState === "minimized") {
        sidebar.classList.add("minimized");
        toggleIcon.textContent = "menu";
        mainContent.style.marginLeft = "80px";
        mainContent.style.width = "calc(100% - 80px)";
    } else {
        toggleIcon.textContent = "menu_open";
        mainContent.style.marginLeft = "250px";
        mainContent.style.width = "calc(100% - 250px)";
    }
};
