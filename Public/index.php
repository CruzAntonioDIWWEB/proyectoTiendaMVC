<?php
session_start();

// Cargo la configuración y el autoload
require_once '../config/config.php';
require_once '../vendor/autoload.php';

// Definir controlador y acción por defecto
$controllerName = 'Dashboard';
$action = 'index';

// Obtener controlador y acción de la URL si existen
if (isset($_GET['controller'])) {
    $controllerName = ucfirst($_GET['controller']);
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

// Formar el nombre completo del controlador con namespace
$controllerClass = "Controllers\\{$controllerName}Controller";

// Usando un enfoque más directo con el autoloader
if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
    
    if (method_exists($controller, $action)) {
        // Ejecutar la acción solicitada
        $controller->$action();
    } else {
        // Si la acción no existe, usar el método index del Dashboard
        $dashboard = new Controllers\DashboardController();
        $dashboard->index();
    }
} else {
    // Si el controlador no existe, cargar el Dashboard por defecto
    $dashboard = new Controllers\DashboardController();
    $dashboard->index();
}