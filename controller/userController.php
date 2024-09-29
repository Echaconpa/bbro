<?php

require_once 'config/config.php';

class UserController {

    // Método para mostrar la vista de login para usuarios regulares
    public function login_usuario_view() {
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre_usuario = $_POST['nombre_usuario'];
            $contrasena = $_POST['contrasena'];

            $usuario_id = $this->authenticate_usuario($nombre_usuario, $contrasena);

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


    // Método para autenticar a un usuario regular
    private function authenticate_usuario($nombre_usuario, $contrasena) {
        global $pdo;

        $stmt = $pdo->prepare('SELECT id, contrasena FROM usuarios WHERE nombre_usuario = :nombre_usuario AND rol_id = 2');
        $stmt->execute(['nombre_usuario' => $nombre_usuario]);
        $usuario = $stmt->fetch();

        if ($usuario && $contrasena === $usuario['contrasena']) {
            return $usuario['id'];
        }
        return false;
    }

}



