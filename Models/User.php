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
     * @return mixed El objeto User si la autenticación es correcta, false en caso contrario
     */
    public function login($email, $password)
    {
        try {
            //Verificar si el usuario existe
            $query = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email");
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->execute();

            if ($query->rowCount() == 1) {
                $usuario = $query->fetch(PDO::FETCH_ASSOC);

                //Verificar la contraseña
                if (password_verify($password, $usuario['password'])) {
                    //Asignar los datos del usuario al objeto
                    $this->id = $usuario['id'];
                    $this->nombre = $usuario['nombre'];
                    $this->apellidos = $usuario['apellidos'];
                    $this->email = $usuario['email'];
                    $this->password = $usuario['password']; //Ya está cifrada
                    $this->rol = $usuario['rol'];
                    $this->imagen = $usuario['imagen'];

                    return $this;
                }
            }

            return false;
        } catch (\PDOException $e) {
            error_log("Error en login: " . $e->getMessage());
            return false;
        }
    }
}
