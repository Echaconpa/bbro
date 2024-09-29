<?php

require_once 'config/config.php';

class DashboardController {
// Método para mostrar la vista del dashboard
    public function dashboard_view() {
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /bbro/login');
            exit();
        }

        $nombre_usuario = 'Usuario'; // Aquí puedes realizar una consulta para obtener el nombre del usuario
        include 'view/dashboard.php';
    }
    

    
    
}