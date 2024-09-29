<?php

require_once 'config/config.php';
require_once 'models/TareajeModel.php';

class TareajeController {

    // Método para mostrar la vista de tareaje
    public function tareaje_view() {
        session_start();
        
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /bbro/login');
            exit();
        }

        // Instanciar el modelo de tareaje
        $tareajeModel = new TareajeModel();
        
        // Obtener todas las unidades para mostrar en el filtro
        $unidades = $tareajeModel->getAllUnidades();

        // Obtener la unidad seleccionada desde la URL, si no hay ninguna seleccionada, se mostrará todo el personal
        $unidad_id = isset($_GET['unidad_id']) && $_GET['unidad_id'] !== '' ? $_GET['unidad_id'] : null;

        // Obtener el personal asociado a la unidad seleccionada
        $personales = $tareajeModel->getPersonalPorUnidad($unidad_id);

        // Obtener las abreviaturas desde la base de datos
        $abreviaturas = $tareajeModel->getAbreviaturas();

        // Generar los días del mes
        $days_in_month = range(1, 31); // Ajustable según el mes seleccionado en el frontend.

        // Cargar la vista de tareaje con los datos
        include 'view/tareaje.php';
    }

    // Método para guardar los datos de tareaje (abreviaturas y observaciones)
    public function guardar_tareaje() {
        // Verificar que la solicitud sea POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            exit();
        }

        // Leer los datos enviados en el cuerpo de la solicitud
        $tareajeData = json_decode(file_get_contents('php://input'), true);

        // Instanciar el modelo
        $tareajeModel = new TareajeModel();

        // Recorrer los datos de cada personal y guardarlos en la base de datos
        foreach ($tareajeData as $personalTareaje) {
            $personal_id = $personalTareaje['personal_id'];
            $abreviaturas = $personalTareaje['abreviaturas'];
            $observaciones = $personalTareaje['observaciones'];

            // Guardar el registro de tareaje para cada día y su abreviatura
            foreach ($abreviaturas as $abreviatura) {
                $tareajeModel->guardarRegistroTareaje($personal_id, $abreviatura['dia'], $abreviatura['abreviatura'], $observaciones);
            }
        }

        // Respuesta de éxito
        echo json_encode(['success' => true, 'message' => 'Tareaje guardado exitosamente']);
    }
}
