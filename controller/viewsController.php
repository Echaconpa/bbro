<?php
require_once 'config/config.php';

// Autenticación para administradores (rol_id = 1)
function authenticate_admin($nombre_usuario, $contrasena) {
    global $pdo;

    $stmt = $pdo->prepare('SELECT id, contrasena FROM usuarios WHERE nombre_usuario = :nombre_usuario AND rol_id = 1');
    $stmt->execute(['nombre_usuario' => $nombre_usuario]);
    $usuario = $stmt->fetch();

    if ($usuario && $contrasena === $usuario['contrasena']) {
        return $usuario['id'];
    }
    return false;
}

// Autenticación para usuarios (rol_id = 2)
function authenticate_usuario($nombre_usuario, $contrasena) {
    global $pdo;

    $stmt = $pdo->prepare('SELECT id, contrasena FROM usuarios WHERE nombre_usuario = :nombre_usuario AND rol_id = 2');
    $stmt->execute(['nombre_usuario' => $nombre_usuario]);
    $usuario = $stmt->fetch();

    if ($usuario && $contrasena === $usuario['contrasena']) {
        return $usuario['id'];
    }
    return false;
}

// Vista de login para administradores
function login_view() {
    global $pdo;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre_usuario = $_POST['nombre_usuario'];
        $contrasena = $_POST['contrasena'];

        $usuario_id = authenticate_admin($nombre_usuario, $contrasena);

        if ($usuario_id) {
            session_start();
            $_SESSION['usuario_id'] = $usuario_id;
            header('Location: /bbro/dashboard');
            exit();
        } else {
            $error = 'Nombre de usuario o contraseña incorrectos';
            include 'view/login.php';
        }
    } else {
        include 'view/login.php';
    }
}

// Vista de login para usuarios
function login_usuario_view() {
    global $pdo;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre_usuario = $_POST['nombre_usuario'];
        $contrasena = $_POST['contrasena'];

        $usuario_id = authenticate_usuario($nombre_usuario, $contrasena);

        if ($usuario_id) {
            session_start();
            $_SESSION['usuario_id'] = $usuario_id;
            header('Location: /bbro/dashboard');
            exit();
        } else {
            $error = 'Nombre de usuario o contraseña incorrectos';
            include 'view/loginu.php';
        }
    } else {
        include 'view/loginu.php';
    }
}

// Vista del dashboard
function dashboard_view() {
    session_start();
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: /bbro/login');
        exit();
    }

    $nombre_usuario = 'Usuario'; // Aquí puedes realizar una consulta para obtener el nombre del usuario
    include 'view/dashboard.php';
}

// Vista del tareaje
function tareaje_view() {
    session_start();
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: /bbro/login');
        exit();
    }

    $days_in_month = range(1, 31);
    include 'view/tareaje.php';
}

// Vista de mantenimiento de usuarios
function mantenimiento_usuarios_view() {
    session_start();
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: /bbro/login');
        exit();
    }

    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM usuarios');
    $stmt->execute();
    $usuarios = $stmt->fetchAll();

    include 'view/mantenimiento_usuarios.php';
}

