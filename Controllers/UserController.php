<?php

namespace Controllers;

class UserController
{
    public function registro(){
        // Usar rutas absolutas desde la raíz del proyecto
        require_once __DIR__ . '/../Views/layout/header.php';
        require_once __DIR__ . '/../Views/user/registro.php';
        require_once __DIR__ . '/../Views/layout/footer.php';
    }

    public function save(){
        // Muestro los datos recibidos
        if (isset($_POST)) {
            echo "Datos:";
            echo "Nombre: " . $_POST['nombre'] . "<br>";
            echo "Apellidos: " . $_POST['apellidos'] . "<br>";
            echo "Email: " . $_POST['email'] . "<br>";
        } else {
            echo "No se han recibido datos";
        }
    }
}
