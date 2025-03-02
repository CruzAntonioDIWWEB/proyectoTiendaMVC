<?php

namespace Models;

use PDO;
use config\DatabaseConfig;

class Product
{
    private $id;
    private $categoria_id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $stock;
    private $oferta;
    private $fecha;
    private $imagen;
    private $db;

    //Constructor
    public function __construct()
    {
        //Conexión a la base de datos
        $dbConfig = new DatabaseConfig();
        $this->db = $dbConfig->getConnection();
    }

    //Getters
    public function getId()
    {
        return $this->id;
    }

    public function getCategoriaId()
    {
        return $this->categoria_id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function getOferta()
    {
        return $this->oferta;
    }

    public function getFecha()
    {
        return $this->fecha;
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

    public function setCategoriaId($categoria_id)
    {
        $this->categoria_id = $categoria_id;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    public function setOferta($oferta)
    {
        $this->oferta = $oferta;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }

    /**
     * Obtiene todos los productos de la base de datos
     * @return array Array de productos
     */
    public function getAll()
    {
        try {
            $sql = "SELECT * FROM productos ORDER BY id DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);  //Asegura que devuelve un array asociativo
        } catch (\PDOException $e) {
            error_log("Error en la consulta de productos: " . $e->getMessage());
            return [];  //Devuelve un array vacío en caso de error
        }
    }


    /**
     * Guarda el producto en la base de datos
     * @return bool true si el guardado fue exitoso, false en caso contrario
     */
    public function save()
    {
        try {
            //Valor predeterminado para el campo oferta si no está establecido
            $oferta = $this->oferta ?? "no";  //Asumiendo que por defecto es "no"

            $sql = "INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) 
                    VALUES (:categoria_id, :nombre, :descripcion, :precio, :stock, :oferta, CURDATE(), :imagen)";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':categoria_id', $this->categoria_id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $this->descripcion, PDO::PARAM_STR);
            $stmt->bindParam(':precio', $this->precio, PDO::PARAM_STR);
            $stmt->bindParam(':stock', $this->stock, PDO::PARAM_INT);
            $stmt->bindParam(':oferta', $oferta, PDO::PARAM_STR);
            $stmt->bindParam(':imagen', $this->imagen, PDO::PARAM_STR);

            $result = $stmt->execute();

            if ($result) {
                $this->id = $this->db->lastInsertId();
                return true;
            }

            return false;
        } catch (\PDOException $e) {
            error_log("Error al guardar el producto: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene un producto por su id
     * @param int $id ID del producto
     * @return mixed Objeto con los datos del producto o false
     */
    public function getOneProduct($id)
    {
        try {
            $sql = "SELECT * FROM productos WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado) {
                $this->id = $resultado['id'];
                $this->categoria_id = $resultado['categoria_id'];
                $this->nombre = $resultado['nombre'];
                $this->descripcion = $resultado['descripcion'];
                $this->precio = $resultado['precio'];
                $this->stock = $resultado['stock'];
                $this->oferta = $resultado['oferta'];
                $this->fecha = $resultado['fecha'];
                $this->imagen = $resultado['imagen'];

                return $this;
            }

            return false;
        } catch (\PDOException $e) {
            error_log("Error al obtener el producto: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualiza los datos de un producto existente
     * @return bool true si la actualización fue exitosa, false en caso contrario
     */
    public function update()
    {
        try {
            //Valor predeterminado para oferta si no está establecido ("no" por defecto)
            $oferta = $this->oferta ?? "no";

            $sql = "UPDATE productos SET categoria_id = :categoria_id, nombre = :nombre, 
                descripcion = :descripcion, precio = :precio, stock = :stock, 
                oferta = :oferta";

            //Si se proporciona una nueva imagen se actualiza
            if ($this->imagen) {
                $sql .= ", imagen = :imagen";
            }

            $sql .= " WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':categoria_id', $this->categoria_id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $this->descripcion, PDO::PARAM_STR);
            $stmt->bindParam(':precio', $this->precio, PDO::PARAM_STR);
            $stmt->bindParam(':stock', $this->stock, PDO::PARAM_INT);
            $stmt->bindParam(':oferta', $oferta, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

            //Si se ha proporcionado la imagen se incluye en la actualización
            if ($this->imagen) {
                $stmt->bindParam(':imagen', $this->imagen, PDO::PARAM_STR);
            }

            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error al actualizar producto: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina un producto de la base de datos
     * @return bool true si la eliminación fue exitosa, false en caso contrario
     */
    public function delete()
    {
        try {
            $sql = "DELETE FROM productos WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error al eliminar producto: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene todos los productos de una categoría específica
     * @param int $categoria_id ID de la categoría
     * @return array Array de productos
     */
    public function getProductsByCategory($categoria_id)
    {
        try {
            $sql = "SELECT p.*, c.nombre as categoria_nombre 
                FROM productos p 
                INNER JOIN categorias c ON p.categoria_id = c.id 
                WHERE p.categoria_id = :categoria_id 
                ORDER BY p.id DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error al obtener productos por categoría: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtiene el nombre de una categoría por su ID
     * @param int $categoria_id ID de la categoría
     * @return string Nombre de la categoría o vacío si no existe
     */
    public function getCategoryName($categoria_id)
    {
        try {
            $sql = "SELECT nombre FROM categorias WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $categoria_id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['nombre'] : '';
        } catch (\PDOException $e) {
            error_log("Error al obtener nombre de categoría: " . $e->getMessage());
            return '';
        }
    }
}
