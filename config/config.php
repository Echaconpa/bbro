<?php
// config.php

// Incluir el archivo de conexión a la base de datos
require_once 'conexion.php';

//modo depuracion
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de seguridad
$secret_key = 'tu_secreto_aleatorio_aqui';
$debug = true; // Cambiar a false en producción

// Orígenes confiables para CSRF
$csrf_trusted_origins = [
    'https://4df1-38-25-26-109.ngrok-free.app'
];

// Configuración de rutas para archivos estáticos
$static_url = '/public/';
$static_dirs = [
    'css' => $static_url . 'css/',
    'img' => $static_url . 'img/',
    'js' => $static_url . 'js/',
];

// Configuración de la zona horaria
date_default_timezone_set('UTC');
