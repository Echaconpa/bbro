<?php

require_once 'config/config.php';
require_once 'models/personalModel.php';
class PersonalController {

    // Vista de mantenimiento de personal
    public function personal_view() {
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /bbro/login');
            exit();
        }
        global $pdo;

        // Obtener todo el personal activo
        $stmt = $pdo->prepare('SELECT * FROM personal WHERE activo = 1');
        $stmt->execute();
        $personales = $stmt->fetchAll();

        // Obtener las unidades activas para mostrarlas en el modal de asignación de unidades
        $stmtUnidades = $pdo->prepare('SELECT id, razon_social FROM unidades WHERE activo = 1');
        $stmtUnidades->execute();
        $unidades = $stmtUnidades->fetchAll();

        include 'view/personal.php';
    }

    // Función para agregar un nuevo registro de personal
    public function add_personal() {
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Recibir datos del formulario
                $nombres = $_POST['nombres'];
                $apellidos = $_POST['apellidos'];
                $dni = $_POST['dni'];
                $estado_civil = $_POST['estado_civil'];
                $telefono_personal = $_POST['telefono_personal'];
                $direccion = $_POST['direccion'];
                $telefono_contacto = $_POST['telefono_contacto'];
                $hijos = $_POST['hijos'];
                $curso_sucamec = $_POST['curso_sucamec'];
                $fecha_nacimiento = $_POST['fecha_nacimiento'];
                $fecha_ingreso_bb = $_POST['fecha_ingreso_bb'];
                $cargo = $_POST['cargo'];
                $observaciones = $_POST['observaciones'];
                $foto = $_FILES['foto_personal']['name'] ?? null;

                // Manejo de la imagen subida
                if (!empty($_FILES['foto_personal']['tmp_name'])) {
                    $foto = basename($_FILES['foto_personal']['name']); // Solo el nombre del archivo
                    $ruta_imagen = 'public/img/personal/' . $foto;

                    // Intentar mover la imagen al directorio de imágenes
                    if (!move_uploaded_file($_FILES['foto_personal']['tmp_name'], $ruta_imagen)) {
                        error_log("Error al mover el archivo: " . $_FILES['foto_personal']['error']);
                        echo json_encode(['success' => false, 'message' => 'Error al mover la imagen']);
                        return;
                    }
                }

                // Insertar el nuevo registro de personal
                $stmt = $pdo->prepare('INSERT INTO personal (nombres, apellidos, dni, estado_civil, telefono_personal, direccion, telefono_contacto, hijos, curso_sucamec, fecha_nacimiento, fecha_ingreso_bb, cargo, observaciones, activo, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?)');
                $stmt->execute([$nombres, $apellidos, $dni, $estado_civil, $telefono_personal, $direccion, $telefono_contacto, $hijos, $curso_sucamec, $fecha_nacimiento, $fecha_ingreso_bb, $cargo, $observaciones, $foto]);

                echo json_encode(['success' => true]);
            } catch (Exception $e) {
                error_log($e->getMessage());
                echo json_encode(['success' => false]);
            }
        }
    }

    // Obtener los datos de un personal específico
    public function get_personal() {
        global $pdo;
        $id = $_GET['id'] ?? null;

        if ($id) {
            $stmt = $pdo->prepare('SELECT * FROM personal WHERE id = ?');
            $stmt->execute([$id]);
            $personal = $stmt->fetch();

            if ($personal) {
                echo json_encode(['success' => true, 'personal' => $personal]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Personal no encontrado']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
        }
    }

    // Función para actualizar los datos de un personal existente
    public function update_personal() {
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nombres = $_POST['nombres'];
            $apellidos = $_POST['apellidos'];
            $dni = $_POST['dni'];
            $estado_civil = $_POST['estado_civil'];
            $telefono_personal = $_POST['telefono_personal'];
            $direccion = $_POST['direccion'];
            $telefono_contacto = $_POST['telefono_contacto'];
            $hijos = $_POST['hijos'];
            $curso_sucamec = $_POST['curso_sucamec'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $fecha_ingreso_bb = $_POST['fecha_ingreso_bb'];
            $cargo = $_POST['cargo'];
            $observaciones = $_POST['observaciones'];
            $foto = $_FILES['foto_personal']['name'] ?? null;

            // Manejo de la imagen subida
            if (!empty($_FILES['foto_personal']['tmp_name'])) {
                $foto = basename($_FILES['foto_personal']['name']); // Solo el nombre del archivo
                $ruta_imagen = 'public/img/personal/' . $foto;

                // Intentar mover la imagen al directorio de imágenes
                if (!move_uploaded_file($_FILES['foto_personal']['tmp_name'], $ruta_imagen)) {
                    error_log("Error al mover el archivo: " . $_FILES['foto_personal']['error']);
                    echo json_encode(['success' => false, 'message' => 'Error al mover la imagen']);
                    return;
                }

                // Actualizar los datos incluyendo la imagen
                $stmt = $pdo->prepare('UPDATE personal SET nombres = ?, apellidos = ?, dni = ?, estado_civil = ?, telefono_personal = ?, direccion = ?, telefono_contacto = ?, hijos = ?, curso_sucamec = ?, fecha_nacimiento = ?, fecha_ingreso_bb = ?, cargo = ?, observaciones = ?, foto = ? WHERE id = ?');
                $stmt->execute([$nombres, $apellidos, $dni, $estado_civil, $telefono_personal, $direccion, $telefono_contacto, $hijos, $curso_sucamec, $fecha_nacimiento, $fecha_ingreso_bb, $cargo, $observaciones, $foto, $id]);
            } else {
                // Actualizar sin modificar la imagen
                $stmt = $pdo->prepare('UPDATE personal SET nombres = ?, apellidos = ?, dni = ?, estado_civil = ?, telefono_personal = ?, direccion = ?, telefono_contacto = ?, hijos = ?, curso_sucamec = ?, fecha_nacimiento = ?, fecha_ingreso_bb = ?, cargo = ?, observaciones = ? WHERE id = ?');
                $stmt->execute([$nombres, $apellidos, $dni, $estado_civil, $telefono_personal, $direccion, $telefono_contacto, $hijos, $curso_sucamec, $fecha_nacimiento, $fecha_ingreso_bb, $cargo, $observaciones, $id]);
            }
            echo json_encode(['success' => true]);
        }
    }

    // Eliminar (desactivar) un personal
    public function delete_personal() {
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            if ($id) {
                $stmt = $pdo->prepare('UPDATE personal SET activo = 0 WHERE id = ?');
                $stmt->execute([$id]);

                if ($stmt->rowCount() > 0) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Personal no encontrado o no actualizado']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
            }
        }
    }

    // Vista para mostrar los detalles de un personal
    public function view_personal() {
        global $pdo;
        $id = $_GET['id'] ?? null;

        if ($id) {
            $stmt = $pdo->prepare('SELECT * FROM personal WHERE id = ?');
            $stmt->execute([$id]);
            $personal = $stmt->fetch();

            if ($personal) {
                echo json_encode(['success' => true, 'personal' => $personal]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Personal no encontrado']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
        }
    }

    public function asignar_unidad() {
        global $pdo;
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $personal_id = $_POST['personal_id'] ?? null;
            $unidad_id = $_POST['unidad'] ?? null;
    
            error_log("Personal ID: $personal_id, Unidad ID: $unidad_id");
    
            if ($personal_id && $unidad_id) {
                try {
                    $stmt = $pdo->prepare('UPDATE personal SET unidad_id = ? WHERE id = ?');
                    $stmt->execute([$unidad_id, $personal_id]);
    
                    echo json_encode(['success' => true, 'message' => 'Unidad asignada correctamente.']);
                } catch (PDOException $e) {
                    error_log("Error al asignar la unidad: " . $e->getMessage());
                    echo json_encode(['success' => false, 'message' => 'Error al asignar la unidad']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
            }
        }
    }
    
    public function registro_sucamec() {
        global $pdo;
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $personal_id = $_POST['personal_id'] ?? null;
            $emi_sucamec = $_POST['emi_sucamec'] ?? null;
            $cad_sucamec = $_POST['cad_sucamec'] ?? null;
    
            // Verificar si los datos están presentes
            if ($personal_id && $emi_sucamec && $cad_sucamec) {
                // Instanciar el modelo y realizar la actualización
                try {
                    $personalModel = new PersonalModel($pdo); // Instanciar el modelo
                    $updated = $personalModel->updateSucamec($personal_id, $emi_sucamec, $cad_sucamec);
    
                    if ($updated) {
                        echo json_encode(['success' => true]);
                    } else {
                        throw new Exception('Error al actualizar SUCAMEC');
                    }
                } catch (Exception $e) {
                    error_log('Error en registro SUCAMEC: ' . $e->getMessage());
                    echo json_encode(['success' => false, 'message' => 'Error al actualizar los datos de SUCAMEC.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
            }
        }
    }
}    
