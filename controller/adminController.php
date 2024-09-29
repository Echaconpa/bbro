<?php

require_once 'config/config.php';

class AdminController {

    // Método para mostrar la vista de login para administradores
    public function login_view() {
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre_usuario = $_POST['nombre_usuario'];
            $contrasena = $_POST['contrasena'];

            $usuario_id = $this->authenticate_admin($nombre_usuario, $contrasena);

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

    // Método para autenticar a un administrador
    private function authenticate_admin($nombre_usuario, $contrasena) {
        global $pdo;
    
        $stmt = $pdo->prepare('SELECT id, contrasena FROM usuarios WHERE nombre_usuario = :nombre_usuario AND rol_id = 1');
        $stmt->execute(['nombre_usuario' => $nombre_usuario]);
        $usuario = $stmt->fetch();
    
        if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
            return $usuario['id'];
        }
        return false;
    }

    // Función para cerrar sesión
    public function logout() {
        session_start();

        // Limpiar todas las variables de sesión
        $_SESSION = [];

        // Eliminar la cookie de sesión si existe
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destruir la sesión
        session_destroy();

        // Redirigir a la página de inicio de sesión
        header("Location: /bbro/login");
        exit;
    }
}

