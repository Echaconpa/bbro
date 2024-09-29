<?php

require_once 'config/config.php';

class ModelsController {

    public function mantenimiento_usuarios_view() {
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /bbro/login');
            exit();
        }
    
        global $pdo;
        // Seleccionar solo los usuarios activos
        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE activo = 1');
        $stmt->execute();
        $usuarios = $stmt->fetchAll(); // Aquí se obtiene la lista de usuarios activos
    
        include 'view/mantenimiento_usuarios.php'; // Incluye la vista y se espera que la variable $usuarios se use dentro de la vista
    }
    

    public function add_usuario() {
        global $pdo;
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $dni = $_POST['dni'];
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $nombre_usuario = $_POST['nombre_usuario'];
                $correo = $_POST['correo_electronico'];
                $telefono = $_POST['telefono'];
                $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
                $rol_id = $_POST['rol_id'];
    
                // Insertar el campo activo con valor 1
                $stmt = $pdo->prepare('INSERT INTO usuarios (dni, nombre, apellido, nombre_usuario, correo_electronico, telefono, contrasena, rol_id, activo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)');
                $stmt->execute([$dni, $nombre, $apellido, $nombre_usuario, $correo, $telefono, $contrasena, $rol_id]);
    
                echo json_encode(['success' => true]);
            } catch (Exception $e) {
                error_log($e->getMessage());
                echo json_encode(['success' => false]);
            }
        }
    }
    

    // Obtener los datos de un usuario
    public function get_usuario() {
        global $pdo;

        $id = $_GET['id'] ?? null;

        if ($id) {
            $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE id = ?');
            $stmt->execute([$id]);
            $usuario = $stmt->fetch();

            if ($usuario) {
                echo json_encode(['success' => true, 'usuario' => $usuario]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
        }
    }

    // Actualizar un usuario
    public function update_usuario() {
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $dni = $_POST['dni'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $nombre_usuario = $_POST['nombre_usuario'];
            $correo = $_POST['correo_electronico'];
            $rol_id = $_POST['rol_id'];

            // Verificar si se cambió la contraseña
            $contrasena = $_POST['contrasena'];
            if (!empty($contrasena)) {
                $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
            } else {
                $stmt = $pdo->prepare('SELECT contrasena FROM usuarios WHERE id = ?');
                $stmt->execute([$id]);
                $contrasena = $stmt->fetchColumn();
            }

            $stmt = $pdo->prepare('UPDATE usuarios SET dni = ?, nombre = ?, apellido = ?, nombre_usuario = ?, correo_electronico = ?, contrasena = ?, rol_id = ? WHERE id = ?');
            $stmt->execute([$dni, $nombre, $apellido,$nombre_usuario, $correo, $contrasena, $rol_id, $id]);

            echo json_encode(['success' => true]);
        }
    }
    
    public function delete_usuario() {
        global $pdo;
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
    
            // Verifica si el ID fue proporcionado
            if ($id) {
                try {
                    // Prepara la actualización del campo 'activo' a 0
                    $stmt = $pdo->prepare('UPDATE usuarios SET activo = 0 WHERE id = ?');
                    $stmt->execute([$id]);
    
                    // Verifica si la fila fue afectada (si realmente se actualizó el campo)
                    if ($stmt->rowCount() > 0) {
                        echo json_encode(['success' => true]);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Usuario no encontrado o no actualizado']);
                    }
                } catch (Exception $e) {
                    // Muestra el mensaje de error en los logs del servidor
                    error_log('Error en la actualización del usuario: ' . $e->getMessage());
                    echo json_encode(['success' => false, 'message' => 'Error en la base de datos al actualizar el usuario']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'ID de usuario no proporcionado']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
        }
    }
}    