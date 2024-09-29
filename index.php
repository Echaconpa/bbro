<?php

// Incluir la configuración y las rutas
require_once 'config/config.php';
require_once 'config/routes.php';

// Capturar la ruta actual y limpiar espacios
$uri = trim($_GET['url'] ?? '', '/');
$method = $_SERVER['REQUEST_METHOD'];

// Si no hay ruta especificada, redirigir a la vista de login
if ($uri === '') {
    $uri = 'login';
}

// Procesar la ruta actual
route($uri, $method, $routes);
