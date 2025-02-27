<?php
session_start();
//Cargo la configuaración de la base de datos
require_once '../config/config.php';

// Cargar controladores
require_once __DIR__ . '/../Controllers/UserController.php';

// Control de la URL
if (isset($_GET['controller'])) {
    $nombre_controlador = 'Controllers\\' . ucfirst($_GET['controller']) . 'Controller';
} else {
    // Controlador por defecto
    include '../Views/layout/header.php';
    include '../Views/home/index.php';
    include '../Views/layout/footer.php';
    exit();
}

// Comprobar si existe el controlador
if (class_exists($nombre_controlador)) {
    $controlador = new $nombre_controlador();
    
    // Comprobar si existe la acción
    if (isset($_GET['action']) && method_exists($controlador, $_GET['action'])) {
        $action = $_GET['action'];
        $controlador->$action();
    } else {
        // Acción por defecto
        include '../Views/layout/header.php';
        include '../Views/home/index.php';
        include '../Views/layout/footer.php';
    }
} else {
    // Controlador por defecto
    include '../Views/layout/header.php';
    include '../Views/home/index.php';
    include '../Views/layout/footer.php';
}

?>