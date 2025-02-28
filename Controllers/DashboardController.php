<?php

namespace Controllers;

class DashboardController {
    
    /**
     * Método index que carga la vista principal del dashboard
     * Incluye el header, el contenido de home y el footer
     */
    public function index() {
        // Cargar el header
        require_once '../Views/layout/header.php';
        
        // Cargar el contenido principal (home)
        require_once '../Views/home/index.php';
        
        // Cargar el footer
        require_once '../Views/layout/footer.php';
    }
}
?>