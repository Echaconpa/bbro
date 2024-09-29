<?php

class UnidadesModel {
    private $pdo;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Obtener todas las unidades activas
    public function getAllUnidades() {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM unidades WHERE activo = 1');
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Error al obtener las unidades: ' . $e->getMessage());
            return [];
        }
    }

    // Agregar una nueva unidad
    public function addUnidad($razon_social, $ruc_dni, $direccion, $rubro, $encargado_seguridad, $telf_encargado, $fijo_encargado, $segundo_contacto, $telf_scontacto, $fijo_scontacto, $puesto_vigilancia, $comisaria, $serenazgo, $bomberos, $samu, $observaciones, $foto) {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO unidades (razon_social, ruc_dni, direccion, rubro, encargado_seguridad, telf_encargado, fijo_encargado, segundo_contacto, telf_scontacto, fijo_scontacto, puesto_vigilancia, comisaria, serenazgo, bomberos, samu, observaciones, foto, activo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)');
            return $stmt->execute([$razon_social, $ruc_dni, $direccion, $rubro, $encargado_seguridad, $telf_encargado, $fijo_encargado, $segundo_contacto, $telf_scontacto, $fijo_scontacto, $puesto_vigilancia, $comisaria, $serenazgo, $bomberos, $samu, $observaciones, $foto]);
        } catch (PDOException $e) {
            error_log('Error al agregar la unidad: ' . $e->getMessage());
            return false;
        }
    }

    // Actualizar una unidad existente
    public function updateUnidad($razon_social, $ruc_dni, $direccion, $rubro, $encargado_seguridad, $telf_encargado, $fijo_encargado, $segundo_contacto, $telf_scontacto, $fijo_scontacto, $puesto_vigilancia, $comisaria, $serenazgo, $bomberos, $samu, $observaciones, $foto, $id) {
        try {
            $stmt = $this->pdo->prepare('UPDATE unidades SET razon_social = ?, ruc_dni = ?, direccion = ?, rubro = ?, encargado_seguridad = ?, telf_encargado = ?, fijo_encargado = ?, segundo_contacto = ?, telf_scontacto = ?, fijo_scontacto = ?, puesto_vigilancia = ?, comisaria = ?, serenazgo = ?, bomberos = ?, samu = ?, observaciones = ?, foto = ? WHERE id = ?');
            return $stmt->execute([$razon_social, $ruc_dni, $direccion, $rubro, $encargado_seguridad, $telf_encargado, $fijo_encargado, $segundo_contacto, $telf_scontacto, $fijo_scontacto, $puesto_vigilancia, $comisaria, $serenazgo, $bomberos, $samu, $observaciones, $foto, $id]);
        } catch (PDOException $e) {
            error_log('Error al actualizar la unidad: ' . $e->getMessage());
            return false;
        }
    }

    // Eliminar una unidad (cambiar el campo 'activo' a 0)
    public function deleteUnidad($id) {
        try {
            $stmt = $this->pdo->prepare('UPDATE unidades SET activo = 0 WHERE id = ?');
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log('Error al eliminar la unidad: ' . $e->getMessage());
            return false;
        }
    }
}
