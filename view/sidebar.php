<head>
<!-- Incluyendo los archivos CSS y JS para la barra lateral -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet"  type="text/css" href="/bbro/public/css/sidebar.css">

</head>
<!-- view/sidebar.php -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <i class="material-icons toggle-sidebar" onclick="toggleSidebar()">menu</i> <!-- Ícono hamburguesa -->
        <span class="sidebar-title">Menu</span>
    </div>
    <ul class="menu-list">
        <li><a href="/bbro/dashboard" class="menu-item"><i class="material-icons">dashboard</i><span class="menu-text"> Dashboard</span></a></li>
        <li><a href="/bbro/mantenimiento_usuarios" class="menu-item"><i class="material-icons">group</i><span class="menu-text"> MANT. USUARIO</span></a></li>
        <li><a href="#" class="menu-item"><i class="material-icons">assignment</i><span class="menu-text"> ROL DE SERVICIOS</span></a></li>
        <li><a href="/bbro/tareaje" class="menu-item"><i class="material-icons">event_note</i><span class="menu-text"> TAREAJE</span></a></li>
        <li><a href="#" class="menu-item"><i class="material-icons">medical_services</i><span class="menu-text"> FICHA DE EMERGENCIA</span></a></li>
        <ul>
            <li><a href="/bbro/personal" class="menu-item"><i class="material-icons">person</i><span class="menu-text"> PERSONAL</span></a></li>
            <li><a href="/bbro/unidades" class="menu-item"><i class="material-icons">domain</i><span class="menu-text"> UNIDADES</span></a></li>
        </ul>
        <li><a href="#" class="menu-item"><i class="material-icons">report_problem</i><span class="menu-text"> REPORTE DE OCURRENCIA</span></a></li>
        <li><a href="#" class="menu-item"><i class="material-icons">book</i><span class="menu-text"> PARTE DIARIO</span></a></li>
    </ul>
</div>

<script src="/bbro/public/js/sidebar.js"></script>