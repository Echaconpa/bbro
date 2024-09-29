<?php

class PersonalModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Obtener todo el personal activo
    public function getAllPersonal() {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM personal WHERE activo = 1');
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Error al obtener el personal: ' . $e->getMessage());
            return [];
        }
    }

    // Agregar un nuevo usuario
    public function addPersonal($nombres, $apellidos, $dni, $estado_civil, $telefono_personal, $direccion, $telefono_contacto, $hijos, $curso_sucamec, $fecha_nacimiento, $fecha_ingreso_bb, $cargo, $observaciones, $foto) {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO personal (nombres, apellidos, dni, estado_civil, telefono_personal, direccion, telefono_contacto, hijos, curso_sucamec, fecha_nacimiento, fecha_ingreso_bb, cargo, observaciones, activo, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?)');
            return $stmt->execute([$nombres, $apellidos, $dni, $estado_civil, $telefono_personal, $direccion, $telefono_contacto, $hijos, $curso_sucamec, $fecha_nacimiento, $fecha_ingreso_bb, $cargo, $observaciones, $foto]);
        } catch (PDOException $e) {
            error_log('Error al agregar el personal: ' . $e->getMessage());
            return false;
        }
    }

    // Actualizar un usuario existente
    public function updatePersonal($nombres, $apellidos, $dni, $estado_civil, $telefono_personal, $direccion, $telefono_contacto, $hijos, $curso_sucamec, $fecha_nacimiento, $fecha_ingreso_bb, $cargo, $observaciones, $foto, $id) {
        try {
            $stmt = $this->pdo->prepare('UPDATE personal SET nombres = ?, apellidos = ?, dni = ?, estado_civil = ?, telefono_personal = ?, direccion = ?, telefono_contacto = ?, hijos = ?, curso_sucamec = ?, fecha_nacimiento = ?, fecha_ingreso_bb = ?, cargo = ?, observaciones = ?, foto = ? WHERE id = ?');
            return $stmt->execute([$nombres, $apellidos, $dni, $estado_civil, $telefono_personal, $direccion, $telefono_contacto, $hijos, $curso_sucamec, $fecha_nacimiento, $fecha_ingreso_bb, $cargo, $observaciones, $foto, $id]);
        } catch (PDOException $e) {
            error_log('Error al actualizar el personal: ' . $e->getMessage());
            return false;
        }
    }

    // Desactivar (eliminar) un personal
    public function deletePersonal($id) {
        try {
            $stmt = $this->pdo->prepare('UPDATE personal SET activo = 0 WHERE id = ?');
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log('Error al eliminar el personal: ' . $e->getMessage());
            return false;
        }
    }

    // Asignar una unidad a un personal
    public function assignUnitToPersonal($personal_id, $unidad_id) {
        try {
            $stmt = $this->pdo->prepare('UPDATE personal SET unidad_id = ? WHERE id = ?');
            return $stmt->execute([$unidad_id, $personal_id]);
        } catch (PDOException $e) {
            error_log('Error al asignar la unidad al personal: ' . $e->getMessage());
            return false;
        }
    }
}
