<?php
namespace Models;

use PDO;
use config\DatabaseConfig;

class Category {
    // Propiedades
    private $id;
    private $nombre;
    private $descripcion;
    private $db;

    // Constructor
    public function __construct() {
        // Conexión a la base de datos
        $dbConfig = new DatabaseConfig();
        $this->db = $dbConfig->getConnection();
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    /**
     * Guarda la categoría en la base de datos
     * @return bool true si el guardado fue exitoso, false en caso contrario
     */
    public function save() {
        try {
            // Cambia esta consulta para que solo inserte los campos que existen
            $sql = "INSERT INTO categorias (nombre) VALUES (:nombre)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
            // Ya no incluimos el campo descripcion
            
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error al guardar categoría: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualiza los datos de una categoría existente
     * @return bool true si la actualización fue exitosa, false en caso contrario
     */
    public function update() {
        try {
            $sql = "UPDATE categorias SET nombre = :nombre WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error al actualizar categoría: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina una categoría de la base de datos
     * @return bool true si la eliminación fue exitosa, false en caso contrario
     */
    public function delete() {
        try {
            $sql = "DELETE FROM categorias WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error al eliminar categoría: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene todas las categorías de la base de datos
     * @return array Array de categorías
     */
    public function getAll() {
        try {
            $sql = "SELECT * FROM categorias ORDER BY id DESC";
            $categorias = $this->db->query($sql);
            
            return $categorias->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error al obtener categorías: " . $e->getMessage());
            return array();
        }
    }

    /**
     * Obtiene una categoría por su id
     * @param int $id ID de la categoría
     * @return mixed Objeto con los datos de la categoría o false
     */
    public function getOneCategory($id) {
        try {
            $sql = "SELECT * FROM categorias WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($resultado) {
                $this->id = $resultado['id'];
                $this->nombre = $resultado['nombre'];
                if (isset($resultado['descripcion'])) {
                    $this->descripcion = $resultado['descripcion'];
                }
                
                return $this;
            }
            
            return false;
        } catch (\PDOException $e) {
            error_log("Error al obtener la categoría: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verifica si una categoría existe por su nombre
     * @param string $nombre Nombre de la categoría
     * @return bool true si existe, false si no
     */
    public function checkCategoryExists($nombre) {
        try {
            $sql = "SELECT * FROM categorias WHERE nombre = :nombre";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            error_log("Error al verificar categoría: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Verifica si existe otra categoría con el mismo nombre excepto la categoría con el ID proporcionado
     * @param string $nombre Nombre de la categoría
     * @param int $id ID de la categoría a excluir de la verificación
     * @return bool true si existe otra categoría con el mismo nombre, false si no
     */
    public function checkCategoryExistsExcept($nombre, $id) {
        try {
            $sql = "SELECT * FROM categorias WHERE nombre = :nombre AND id != :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            error_log("Error al verificar categoría: " . $e->getMessage());
            return false;
        }
    }
}