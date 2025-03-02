<?php
session_start();

//Cargo la configuración y el autoload
require_once '../config/config.php';
require_once '../vendor/autoload.php';

if (!isset($_SESSION['usuario']) && isset($_COOKIE['remember_me'])) {
    $user_id = $_COOKIE['remember_me'];
    
    //Creo una instancia de usuario y obtengo los datos del usuario
    $user = new \Models\User();
    $user_data = $user->getUserById($user_id);
    
    if ($user_data) {
        //Se restaura la sesión
        $_SESSION['usuario'] = [
            'id' => $user_data->getId(),
            'nombre' => $user_data->getNombre(),
            'apellidos' => $user_data->getApellidos(),
            'email' => $user_data->getEmail(),
            'rol' => $user_data->getRol()
        ];
        
        //Renuevo la cookie por otros 7 días
        setcookie('remember_me',$user_id, time() + (7 * 24 * 60 * 60), '/');
    }
}

//Defino controlador y acción por defecto
$controllerName = 'Dashboard';
$action = 'index';

//Si existen parámetros en la URL se obtienen 
if (isset($_GET['controller'])) {
    $controllerName = ucfirst($_GET['controller']);
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

//Se define el nombre del controlador y la acción a ejecutar
$controllerClass = "Controllers\\{$controllerName}Controller";

//Uso del Autoload para cargar el controlador solicitado
if (class_exists($controllerClass)) {
    $controller = new $controllerClass();

    if (method_exists($controller, $action)) {
        //Ejecución de la acción solicitada
        $controller->$action();
    } else {
        //Si la acción no existe se usa el método index del Dashboard
        $dashboard = new Controllers\DashboardController();
        $dashboard->index();
    }
} else {
    //Si el controlador no existe se carga el Dashboard por defecto
    $dashboard = new Controllers\DashboardController();
    $dashboard->index();
}
