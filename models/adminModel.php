<?php

class AdminModel {

    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    // Método para autenticar administradores
    public function authenticate_admin($nombre_usuario, $contrasena) {
        try {
            $stmt = $this->pdo->prepare('SELECT id, contrasena FROM usuarios WHERE nombre_usuario = :nombre_usuario AND rol_id = 1');
            $stmt->execute(['nombre_usuario' => $nombre_usuario]);
            $usuario = $stmt->fetch();

            if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
                return $usuario['id'];
            }
            return false;
        } catch (PDOException $e) {
            error_log('Error en la autenticación del administrador: ' . $e->getMessage());
            return false;
        }
    }

    // Método para obtener el nombre de usuario por ID
    public function getUserNameById($usuario_id) {
        try {
            $stmt = $this->pdo->prepare('SELECT nombre FROM usuarios WHERE id = :id');
            $stmt->execute(['id' => $usuario_id]);
            $usuario = $stmt->fetch();
            return $usuario ? $usuario['nombre'] : 'Usuario';
        } catch (PDOException $e) {
            error_log('Error al obtener el nombre de usuario: ' . $e->getMessage());
            return 'Usuario';
        }
    }
}
