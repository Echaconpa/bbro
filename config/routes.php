<?php
// routes.php

// Carga de controladores
require_once 'controller/adminController.php';
require_once 'controller/modelsController.php';
require_once 'controller/userController.php';
require_once 'controller/personalController.php';
require_once 'controller/unidadesController.php'; // Nuevo controlador de Unidades
require_once 'controller/tareajeController.php';
require_once 'controller/dashboardController.php';

// Definición de rutas
$routes = [
    'GET' => [
        '' => [new AdminController(), 'login_view'],
        'login' => [new AdminController(), 'login_view'],
        'logout' => [new AdminController(), 'logout'],  // Aquí se define la ruta para cerrar sesión
        'loginu' => [new UserController(), 'login_usuario_view'],
        'dashboard' => [new DashboardController(), 'dashboard_view'],
        'tareaje' => [new TareajeController(), 'tareaje_view'],
        'mantenimiento_usuarios' => [new ModelsController(), 'mantenimiento_usuarios_view'],
        'get_usuario' => [new ModelsController(), 'get_usuario'], // Ruta para obtener un usuario
        'personal' => [new PersonalController(), 'personal_view'], // Vista del personal
        'get_personal' => [new PersonalController(), 'get_personal'], // Ruta para obtener datos de personal
        'view_personal' => [new PersonalController(), 'view_personal'], // Vista de un personal específico

        // Rutas para el módulo de Unidades
        'unidades' => [new UnidadesController(), 'unidades_view'], // Nueva ruta para visualizar todas las unidades
        'get_unidad' => [new UnidadesController(), 'get_unidad'], // Nueva ruta para obtener una unidad específica
        'view_unidad' => [new UnidadesController(), 'view_unidad'], // Nueva ruta para visualizar los detalles de una unidad
    ],
    'POST' => [
        'login' => [new AdminController(), 'login_view'],
        'loginu' => [new UserController(), 'login_usuario_view'],
        'addUsuario' => [new ModelsController(), 'add_usuario'], // Ruta para agregar un usuario
        'updateUsuario' => [new ModelsController(), 'update_usuario'], // Ruta para actualizar un usuario
        'deleteUsuario' => [new ModelsController(), 'delete_usuario'], // Ruta para eliminar un usuario

        'addPersonal' => [new PersonalController(), 'add_personal'], // Ruta para agregar personal
        'updatePersonal' => [new PersonalController(), 'update_personal'], // Ruta para actualizar personal
        'deletePersonal' => [new PersonalController(), 'delete_personal'], // Ruta para eliminar personal
        'asignarUnidad' => [new PersonalController(), 'asignar_unidad'], // Nueva ruta para asignar una unidad a un personal
        'registroSucamec' => [new PersonalController(), 'registro_sucamec'], // Ruta para registrar datos de SUCAMEC
        // Rutas para el módulo de Unidades
        'addUnidad' => [new UnidadesController(), 'add_unidad'], // Nueva ruta para agregar una unidad
        'updateUnidad' => [new UnidadesController(), 'update_unidad'], // Nueva ruta para actualizar una unidad
        'deleteUnidad' => [new UnidadesController(), 'delete_unidad'], // Nueva ruta para eliminar una unidad

        // Ruta para guardar los datos de tareaje
        'tareaje/guardar' => [new TareajeController(), 'guardar_tareaje'], // Nueva ruta para guardar el tareaje
        
    ],
];

// Función para manejar las rutas
function route($uri, $method, $routes) {
    if (isset($routes[$method][$uri])) {
        call_user_func($routes[$method][$uri]);
    } else {
        echo "404 Not Found";
    }
}

// Obtener URI y método de la solicitud
$uri = trim($_GET['url'] ?? '', '/');
$method = $_SERVER['REQUEST_METHOD'];

