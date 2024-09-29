<?php

require_once 'config/config.php';

class UnidadesController {

    // Vista de mantenimiento de unidades
    public function unidades_view() {
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /bbro/login');
            exit();
        }
        global $pdo;

        // Obtener todas las unidades activas
        $stmt = $pdo->prepare('SELECT * FROM unidades WHERE activo = 1');
        $stmt->execute();
        $unidades = $stmt->fetchAll();

        include 'view/unidades.php';
    }

    // Función para agregar una nueva unidad
    public function add_unidad() {
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Recibir datos del formulario
                $razon_social = $_POST['razon_social'];
                $ruc_dni = $_POST['ruc_dni'];
                $direccion = $_POST['direccion'];
                $rubro = $_POST['rubro'];
                $encargado_seguridad = $_POST['encargado_seguridad'];
                $telf_encargado = $_POST['telf_encargado'];
                $fijo_encargado = $_POST['fijo_encargado'];
                $segundo_contacto = $_POST['segundo_contacto'];
                $telf_scontacto = $_POST['telf_scontacto'];
                $fijo_scontacto = $_POST['fijo_scontacto'];
                $puesto_vigilancia = $_POST['puesto_vigilancia'];
                $comisaria = $_POST['comisaria'];
                $serenazgo = $_POST['serenazgo'];
                $bomberos = $_POST['bomberos'];
                $samu = $_POST['samu'];
                $observaciones = $_POST['observaciones'];
                $foto = $_FILES['foto_unidad']['name'] ?? null;

                // Manejo de la imagen subida
                if (!empty($_FILES['foto_unidad']['tmp_name'])) {
                    $foto = basename($_FILES['foto_unidad']['name']); // Solo el nombre del archivo
                    $ruta_imagen = 'public/img/unidades/' . $foto;

                    // Intentar mover la imagen al directorio de imágenes
                    if (!move_uploaded_file($_FILES['foto_unidad']['tmp_name'], $ruta_imagen)) {
                        error_log("Error al mover el archivo: " . $_FILES['foto_unidad']['error']);
                        echo json_encode(['success' => false, 'message' => 'Error al mover la imagen']);
                        return;
                    }
                }

                // Insertar el nuevo registro de unidad
                $stmt = $pdo->prepare('INSERT INTO unidades (razon_social, ruc_dni, direccion, rubro, encargado_seguridad, telf_encargado, fijo_encargado, segundo_contacto, telf_scontacto, fijo_scontacto, puesto_vigilancia, comisaria, serenazgo, bomberos, samu, observaciones, activo, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?)');
                $stmt->execute([$razon_social, $ruc_dni, $direccion, $rubro, $encargado_seguridad, $telf_encargado, $fijo_encargado, $segundo_contacto, $telf_scontacto, $fijo_scontacto, $puesto_vigilancia, $comisaria, $serenazgo, $bomberos, $samu, $observaciones, $foto]);

                echo json_encode(['success' => true]);
            } catch (Exception $e) {
                error_log($e->getMessage());
                echo json_encode(['success' => false]);
            }
        }
    }

    // Obtener los datos de una unidad específica
    public function get_unidad() {
        global $pdo;
        $id = $_GET['id'] ?? null;

        if ($id) {
            $stmt = $pdo->prepare('SELECT * FROM unidades WHERE id = ?');
            $stmt->execute([$id]);
            $unidad = $stmt->fetch();

            if ($unidad) {
                echo json_encode(['success' => true, 'unidad' => $unidad]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Unidad no encontrada']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
        }
    }

    // Función para actualizar los datos de una unidad existente
    public function update_unidad() {
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $razon_social = $_POST['razon_social'];
            $ruc_dni = $_POST['ruc_dni'];
            $direccion = $_POST['direccion'];
            $rubro = $_POST['rubro'];
            $encargado_seguridad = $_POST['encargado_seguridad'];
            $telf_encargado = $_POST['telf_encargado'];
            $fijo_encargado = $_POST['fijo_encargado'];
            $segundo_contacto = $_POST['segundo_contacto'];
            $telf_scontacto = $_POST['telf_scontacto'];
            $fijo_scontacto = $_POST['fijo_scontacto'];
            $puesto_vigilancia = $_POST['puesto_vigilancia'];
            $comisaria = $_POST['comisaria'];
            $serenazgo = $_POST['serenazgo'];
            $bomberos = $_POST['bomberos'];
            $samu = $_POST['samu'];
            $observaciones = $_POST['observaciones'];
            $foto = $_FILES['foto_unidad']['name'] ?? null;

            // Manejo de la imagen subida
            if (!empty($_FILES['foto_unidad']['tmp_name'])) {
                $foto = basename($_FILES['foto_unidad']['name']); // Solo el nombre del archivo
                $ruta_imagen = 'public/img/unidades/' . $foto;

                // Intentar mover la imagen al directorio de imágenes
                if (!move_uploaded_file($_FILES['foto_unidad']['tmp_name'], $ruta_imagen)) {
                    error_log("Error al mover el archivo: " . $_FILES['foto_unidad']['error']);
                    echo json_encode(['success' => false, 'message' => 'Error al mover la imagen']);
                    return;
                }

                // Actualizar los datos incluyendo la imagen
                $stmt = $pdo->prepare('UPDATE unidades SET razon_social = ?, ruc_dni = ?, direccion = ?, rubro = ?, encargado_seguridad = ?, telf_encargado = ?, fijo_encargado = ?, segundo_contacto = ?, telf_scontacto = ?, fijo_scontacto = ?, puesto_vigilancia = ?, comisaria = ?, serenazgo = ?, bomberos = ?, samu = ?, observaciones = ?, foto = ? WHERE id = ?');
                $stmt->execute([$razon_social, $ruc_dni, $direccion, $rubro, $encargado_seguridad, $telf_encargado, $fijo_encargado, $segundo_contacto, $telf_scontacto, $fijo_scontacto, $puesto_vigilancia, $comisaria, $serenazgo, $bomberos, $samu, $observaciones, $foto, $id]);
            } else {
                // Actualizar sin modificar la imagen
                $stmt = $pdo->prepare('UPDATE unidades SET razon_social = ?, ruc_dni = ?, direccion = ?, rubro = ?, encargado_seguridad = ?, telf_encargado = ?, fijo_encargado = ?, segundo_contacto = ?, telf_scontacto = ?, fijo_scontacto = ?, puesto_vigilancia = ?, comisaria = ?, serenazgo = ?, bomberos = ?, samu = ?, observaciones = ? WHERE id = ?');
                $stmt->execute([$razon_social, $ruc_dni, $direccion, $rubro, $encargado_seguridad, $telf_encargado, $fijo_encargado, $segundo_contacto, $telf_scontacto, $fijo_scontacto, $puesto_vigilancia, $comisaria, $serenazgo, $bomberos, $samu, $observaciones, $id]);
            }
            echo json_encode(['success' => true]);
        }
    }

    // Eliminar (desactivar) una unidad
    public function delete_unidad() {
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            if ($id) {
                $stmt = $pdo->prepare('UPDATE unidades SET activo = 0 WHERE id = ?');
                $stmt->execute([$id]);

                if ($stmt->rowCount() > 0) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Unidad no encontrada o no actualizada']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
            }
        }
    }

    // Vista para mostrar los detalles de una unidad
    public function view_unidad() {
        global $pdo;
        $id = $_GET['id'] ?? null;

        if ($id) {
            $stmt = $pdo->prepare('SELECT * FROM unidades WHERE id = ?');
            $stmt->execute([$id]);
            $unidad = $stmt->fetch();

            if ($unidad) {
                echo json_encode(['success' => true, 'unidad' => $unidad]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Unidad no encontrada']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
        }
    }
}
