<?php

require_once 'config/conexion.php';

class TareajeModel {

    // Obtener todas las unidades disponibles
    public function getAllUnidades() {
        global $pdo;
        $sql = "SELECT id, razon_social FROM unidades";
        try {
            $result = $pdo->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error en la consulta: " . $e->getMessage());
        }
    }

    // Obtener todo el personal o el personal de una unidad específica
    public function getPersonalPorUnidad($unidad_id = null) {
        global $pdo;

        try {
            if ($unidad_id) {
                // Si se seleccionó una unidad, obtener solo el personal de esa unidad
                $sql = "SELECT p.id, p.nombres, p.apellidos, p.dni FROM personal p WHERE p.unidad_id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$unidad_id]);
            } else {
                // Si no se seleccionó ninguna unidad, obtener todo el personal
                $sql = "SELECT p.id, p.nombres, p.apellidos, p.dni FROM personal p";
                $stmt = $pdo->query($sql);
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error en la consulta: " . $e->getMessage());
        }
    }

    // Obtener todas las abreviaturas desde la base de datos
    public function getAbreviaturas() {
        global $pdo;
        $sql = "SELECT codigo, descripcion, color_class FROM abreviaturas";
        try {
            $result = $pdo->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error al obtener abreviaturas: " . $e->getMessage());
        }
    }

    // Guardar un registro de tareaje
    public function guardarRegistroTareaje($personal_id, $dia, $abreviatura, $observaciones) {
        global $pdo;

        // Verificar si ya existe un registro de tareaje para el personal y día
        $sql = "SELECT id FROM registros_tareas WHERE personal_id = ? AND tarea_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$personal_id, $dia]);
        $registroExistente = $stmt->fetch();

        if ($registroExistente) {
            // Actualizar el registro existente
            $sql = "UPDATE registros_tareas SET abreviatura = ?, observaciones = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$abreviatura, $observaciones, $registroExistente['id']]);
        } else {
            // Insertar un nuevo registro de tareaje
            $sql = "INSERT INTO registros_tareas (personal_id, tarea_id, abreviatura, observaciones) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$personal_id, $dia, $abreviatura, $observaciones]);
        }
    }
}
