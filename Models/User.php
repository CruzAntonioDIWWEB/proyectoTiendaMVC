<?php

namespace Models;

use PDO;
use config\DatabaseConfig;

//Clase que representa una fila de la tabla usuarios
class User
{
    //Propiedades de la clase
    private $id;
    private $nombre;
    private $apellidos;
    private $email;
    private $password;
    private $rol;
    private $imagen;
    private $db;

    //Constructor
    public function __construct()
    {
        //Conexión a la base de datos usando la nueva clase DatabaseConfig
        $dbConfig = new DatabaseConfig();
        $this->db = $dbConfig->getConnection();
    }

    //Getters
    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    //Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        //Se cifra la contraseña antes de guardarla
        $password_hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 4]); //La cifra 4 veces
        $this->password = $password_hash;
    }

    public function setRol($rol)
    {
        $this->rol = $rol;
    }

    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }

    /**
     * Guarda el usuario en la base de datos
     * @return bool true si el guardado fue exitoso, false en caso contrario
     */
    public function saveDB()
    {
        try {
            //Guardar en la base de datos
            $register = $this->db->prepare('INSERT INTO usuarios VALUES(null, :nombre, :apellidos, :email, :password, :rol, null)');
            $register->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
            $register->bindParam(':apellidos', $this->apellidos, PDO::PARAM_STR);
            $register->bindParam(':email', $this->email, PDO::PARAM_STR);
            $register->bindParam(':password', $this->password, PDO::PARAM_STR);

            //Se asigna "user" como rol por defecto si no se ha especificado
            $rol = $this->rol ?: "user";
            $register->bindParam(':rol', $rol, PDO::PARAM_STR);

            $save = $register->execute();

            return $save;
        } catch (\PDOException $e) {
            //Error al guardar el usuario
            error_log("Error al guardar usuario: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verifica si el usuario existe por su email
     * @param string $email Email a verificar
     * @return bool true si existe, false si no
     */
    public function checkUserExists($email)
    {
        try {
            $query = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email");
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->execute();

            return $query->rowCount() > 0;
        } catch (\PDOException $e) {
            error_log("Error al verificar usuario: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Autentica a un usuario por su email y contraseña
     * @param string $email Email del usuario
     * @param string $password Contraseña sin cifrar
     * @param bool $recuerdame Si se debe recordar el email en una cookie
     * @return mixed El objeto User si la autenticación es correcta, false en caso contrario
     */
    public function login($email, $password, $recuerdame = false)
    {
        //Validación de entradas
        $email = filter_var(trim($email), FILTER_VALIDATE_EMAIL);

        //Verifico si el usuario existe
        $consulta = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email");
        $consulta->bindParam(':email', $email, PDO::PARAM_STR);
        $consulta->execute();

        if ($consulta->rowCount() > 0) {
            $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

            //Verifico la contraseña
            if (password_verify($password, $usuario['password'])) {
                //Asigno los datos del usuario a las propiedades de la clase
                $this->id = $usuario['id'];
                $this->nombre = $usuario['nombre'];
                $this->apellidos = $usuario['apellidos'];
                $this->email = $usuario['email'];
                $this->rol = $usuario['rol'];
                $this->imagen = $usuario['imagen'];

                //Guardo el usuario en la sesión
                $_SESSION['usuario'] = [
                    'id' => $this->id,
                    'nombre' => $this->nombre,
                    'apellidos' => $this->apellidos,
                    'email' => $this->email,
                    'rol' => $this->rol
                ];

                $_SESSION['login'] = "Login correcto";

                if ($recuerdame) {
                    //Creo una cookie con el email del usuario
                    setcookie('emailLogin', $this->email, time() + (30 * 24 * 60 * 60), '/');
                } else {
                    //Si no se marca la casilla de recordar, se elimina la cookie
                    setcookie('emailLogin', "", time() - 3600, '/');
                }

                return $this;
            } else {
                //Contraseña incorrecta
                $_SESSION['errorLogin'] = "Email o contraseña incorrectos";
                return false;
            }
        } else {
            //Usuario no encontrado
            $_SESSION['errorLogin'] = "Email o contraseña incorrectos";
            return false;
        }
    }

    /**
     * Obtiene un usuario por su ID
     * @param int $id ID del usuario
     * @return mixed El objeto User con los datos cargados, false en caso de error
     */
    public function getUserById($id)
    {
        try {
            $query = $this->db->prepare("SELECT * FROM usuarios WHERE id = :id");
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();

            if ($query->rowCount() > 0) {
                $user_data = $query->fetch(PDO::FETCH_ASSOC);

                $this->id = $user_data['id'];
                $this->nombre = $user_data['nombre'];
                $this->apellidos = $user_data['apellidos'];
                $this->email = $user_data['email'];
                $this->rol = $user_data['rol'];
                $this->imagen = $user_data['imagen'];

                return $this;
            }

            return false;
        } catch (\PDOException $e) {
            error_log("Error al obtener usuario por ID: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualiza los datos del usuario en la base de datos
     * @return bool true si la actualización fue exitosa, false en caso contrario
     */
    public function update()
    {
        try {
            $sql = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, email = :email";
            $params = [
                ':nombre' => $this->nombre,
                ':apellidos' => $this->apellidos,
                ':email' => $this->email,
                ':id' => $this->id
            ];

            //Si hay una nueva contraseña se incluye en la actualización
            if (!empty($this->password)) {
                $sql .= ", password = :password";
                $params[':password'] = $this->password;
            }

            //Y si se proporciona un rol se incluye en la actualización
            if (!empty($this->rol)) {
                $sql .= ", rol = :rol";
                $params[':rol'] = $this->rol;
            }

            $sql .= " WHERE id = :id";

            $update = $this->db->prepare($sql);

            foreach ($params as $param => $value) {
                if ($param == ':id') {
                    $update->bindValue($param, $value, PDO::PARAM_INT);
                } else {
                    $update->bindValue($param, $value, PDO::PARAM_STR);
                }
            }

            return $update->execute();
        } catch (\PDOException $e) {
            error_log("Error al actualizar usuario: " . $e->getMessage());
            return false;
        }
    }
}
