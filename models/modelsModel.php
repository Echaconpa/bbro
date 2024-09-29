<?php

class ModelsModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Obtener todos los usuarios
    public function getAllUsuarios() {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE activo = 1');
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Error al obtener los usuarios: ' . $e->getMessage());
            return [];
        }
    }



    // Agregar un nuevo usuario
    public function addUsuario($nombre, $apellido, $correo, $contrasena, $rol_id) {
        try {
            $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare('INSERT INTO usuarios (nombre, apellido, correo_electronico, contrasena, rol_id) VALUES (?, ?, ?, ?, ?)');
            return $stmt->execute([$nombre, $apellido, $correo, $hashed_password, $rol_id]);
        } catch (PDOException $e) {
            error_log('Error al agregar el usuario: ' . $e->getMessage());
            return false;
        }
    }

    // Actualizar un usuario existente
    public function updateUsuario($id, $nombre, $apellido, $correo, $contrasena, $rol_id) {
        try {
            $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare('UPDATE usuarios SET nombre = ?, apellido = ?, correo_electronico = ?, contrasena = ?, rol_id = ? WHERE id = ?');
            return $stmt->execute([$nombre, $apellido, $correo, $hashed_password, $rol_id, $id]);
        } catch (PDOException $e) {
            error_log('Error al actualizar el usuario: ' . $e->getMessage());
            return false;
        }
    }

    // Eliminar un usuario
    public function deleteUsuario($id) {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM usuarios WHERE id = ?');
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log('Error al eliminar el usuario: ' . $e->getMessage());
            return false;
        }
    }
}
