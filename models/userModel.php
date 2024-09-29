<?php

require_once 'config/conexion.php';

class UserModel {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Método para obtener todos los usuarios
    public function getAllUsuarios() {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Método para obtener un usuario por su ID
    public function getUsuarioById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Método para añadir un nuevo usuario
    public function addUsuario($nombre, $apellido, $nombre_usuario, $correo, $contrasena, $telefono, $rol_id) {
        // Hashear la contraseña antes de almacenarla
        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);
        
        $stmt = $this->pdo->prepare('INSERT INTO usuarios (nombre, apellido, nombre_usuario, correo_electronico, contrasena, telefono, rol_id) VALUES (?, ?, ?, ?, ?, ?, ?)');
        return $stmt->execute([$nombre, $apellido, $nombre_usuario, $correo, $hashed_password, $telefono, $rol_id]);
    }

    // Método para actualizar un usuario existente
    public function updateUsuario($id, $nombre, $apellido, $nombre_usuario, $correo, $contrasena, $telefono, $rol_id) {
        // Hashear la contraseña antes de almacenarla
        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);
        
        $stmt = $this->pdo->prepare('UPDATE usuarios SET nombre = ?, apellido = ?, nombre_usuario = ?, correo_electronico = ?, contrasena = ?, telefono = ?, rol_id = ? WHERE id = ?');
        return $stmt->execute([$nombre, $apellido, $nombre_usuario, $correo, $hashed_password, $telefono, $rol_id, $id]);
    }

    // Método para eliminar un usuario
    public function deleteUsuario($id) {
        $stmt = $this->pdo->prepare('DELETE FROM usuarios WHERE id = ?');
        return $stmt->execute([$id]);
    }
    
    // Método para autenticar un usuario (por ejemplo, para login)
    public function authenticate_usuario($nombre_usuario, $contrasena) {
        try {
            $stmt = $this->pdo->prepare('SELECT id, contrasena FROM usuarios WHERE nombre_usuario = :nombre_usuario AND rol_id = 2');
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
}