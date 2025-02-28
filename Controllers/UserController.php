<?php
namespace Controllers;

require_once __DIR__ . '/../Models/User.php';

class UserController{
    public function registro(){
        //Usar rutas absolutas desde la raíz del proyecto
        require_once __DIR__ . '/../Views/layout/header.php';
        require_once __DIR__ . '/../Views/user/registro.php';
        require_once __DIR__ . '/../Views/layout/footer.php';
    }

    public function save() {
        if (isset($_POST) && !empty($_POST['nombre']) && !empty($_POST['apellidos']) && !empty($_POST['email']) 
        && !empty($_POST['password'])) {
            
            //Si se cumple la condición se crea un nuevo usuario
            $user = new \Models\User();
            
            //Validación del email
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['register_error'] = "El email no es válido";
                header("Location: index.php");
                exit();
            }
            
            //Verificación de si ya existe el usuario
            if ($user->checkUserExists($_POST['email'])) {
                $_SESSION['register_error'] = "El email ya está registrado";
                header("Location: index.php");
                exit();
            }
            
            //Asignar valores
            $user->setNombre($_POST['nombre']);
            $user->setApellidos($_POST['apellidos']);
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            
            //Guardar en la base de datos
            $save = $user->saveDB();
            
            if ($save) {
                $_SESSION['register'] = "Registro Completado";
            } else {
                $_SESSION['register'] = "El registro ha fallado";
            }
        } else {
            $_SESSION['register'] = "El registro ha fallado";
        }
        
        header("Location: index.php");
        exit();
    }

    public function loginAction(){
        if (isset($_POST) && !empty($_POST['email']) && !empty($_POST['password'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $recuerdame = isset($_POST['recuerdame']);

            $user = new \Models\User();
            $login = $user->login($email, $password, $recuerdame);

            if($login){
                //Redirigir a la página de inicio con el usuario logueado
                header("Location: index.php");
                exit();
            } else {
                //Error al loguear
                header("Location: index.php?controller=user&action=loginForm");
                exit();
            }
        } else {
            $_SESSION['errorLogin'] = "Completa todos los cambios";
            header("Location: index.php?controller=user&action=loginForm");
            exit();
        }
    }

    //Función para mostrar el formulario de login junto con el header y footer
    public function loginForm(){
        require_once __DIR__ . '/../Views/layout/header.php';
        require_once __DIR__ . '/../Views/user/login.php';
        require_once __DIR__ . '/../Views/layout/footer.php';
    }

    //Función para cerrar sesión
    public function logout(){
        if(isset($_SESSION['usuario'])){
            unset($_SESSION['usuario']);
        }
        
        header("Location: index.php");
        exit();
    }
}
