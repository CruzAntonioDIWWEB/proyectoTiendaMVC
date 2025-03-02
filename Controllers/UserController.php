<?php

namespace Controllers;

require_once __DIR__ . '/../Models/User.php';

class UserController
{
    public function registro()
    {
        require_once __DIR__ . '/../Views/layout/header.php';
        require_once __DIR__ . '/../Views/user/registro.php';
        require_once __DIR__ . '/../Views/layout/footer.php';
    }

    public function save()
    {
        //Si se han enviado los datos del formulario
        if (
            isset($_POST) && !empty($_POST['nombre']) && !empty($_POST['apellidos']) && !empty($_POST['email'])
            && !empty($_POST['password'])
        ) {

            //Me creo un usuario
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

            $user->setNombre($_POST['nombre']);
            $user->setApellidos($_POST['apellidos']);
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);

            //Se guardan los valores en la base de datos
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

    public function loginAction()
    {
        if (isset($_POST) && !empty($_POST['email']) && !empty($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $recuerdame = isset($_POST['recuerdame']);

            $user = new \Models\User();
            $login = $user->login($email, $password, $recuerdame);

            if ($login) {
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
    public function loginForm()
    {
        require_once __DIR__ . '/../Views/layout/header.php';
        require_once __DIR__ . '/../Views/user/login.php';
        require_once __DIR__ . '/../Views/layout/footer.php';
    }

    //Función para cerrar sesión
    public function logout()
    {
        if (isset($_SESSION['usuario'])) {
            unset($_SESSION['usuario']);
        }

        header("Location: index.php");
        exit();
    }

    //Función para mostrar el formulario de edición de perfil
    public function edit()
    {
        //Primero se verifica que el usuario esté logueado
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php");
            exit();
        }

        //Se obtienen los datos del usuario
        $user = new \Models\User();
        $user_data = $user->getUserById($_SESSION['usuario']['id']);

        //Y si existen, se muestran en el formulario
        if ($user_data) {
            require_once __DIR__ . '/../Views/layout/header.php';
            require_once __DIR__ . '/../Views/user/edit.php';
            require_once __DIR__ . '/../Views/layout/footer.php';
        } else {
            $_SESSION['user_error'] = "Error al cargar los datos del usuario";
            header("Location: index.php");
            exit();
        }
    }

    //Función para actualizar los datos del usuario
    public function update()
    {
        //Verificación de que el usuario esté logueado
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php");
            exit();
        }

        if (isset($_POST) && !empty($_POST['nombre']) && !empty($_POST['apellidos']) && !empty($_POST['email'])) {
            //Se validan los datos
            $nombre = trim(filter_var($_POST['nombre'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $apellidos = trim(filter_var($_POST['apellidos'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

            if (!$email) {
                $_SESSION['user_error'] = "El email no es válido";
                header("Location: index.php?controller=user&action=edit");
                exit();
            }

            //Cuando se validan los datos, se actualizan
            $user = new \Models\User();
            $user->setId($_SESSION['usuario']['id']);
            $user->setNombre($nombre);
            $user->setApellidos($apellidos);
            $user->setEmail($email);

            //Se verifica si se está actualizando la contraseña
            if (!empty($_POST['password'])) {
                $user->setPassword($_POST['password']);
            }

            //Si el usuario es admin se permite cambiar el rol
            if (isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] == 'admin' && isset($_POST['rol'])) {
                $user->setRol($_POST['rol']);
            }

            $update = $user->update();

            if ($update) {
                //Se actualiza la sesión con los nuevos datos
                $_SESSION['usuario']['nombre'] = $nombre;
                $_SESSION['usuario']['apellidos'] = $apellidos;
                $_SESSION['usuario']['email'] = $email;

                //Si el usuario es admin y ha cambiado el rol se actualiza también en la sesión
                if (isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] == 'admin' && isset($_POST['rol'])) {
                    $_SESSION['usuario']['rol'] = $_POST['rol'];
                }

                $_SESSION['user_update'] = "Datos actualizados correctamente";
            } else {
                $_SESSION['user_error'] = "Error al actualizar los datos";
            }
        } else {
            $_SESSION['user_error'] = "Faltan datos obligatorios";
        }

        header("Location: index.php?controller=user&action=edit");
        exit();
    }
}
