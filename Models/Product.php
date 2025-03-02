<?php 
namespace Models;

use PDO;
use config\DatabaseConfig;

class Product {
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
    public function __construct() {
        //Conexión a la base de datos
        $dbConfig = new DatabaseConfig();
        $this->db = $dbConfig->getConnection();
    }

    //Getters
    public function getId() {
        return $this->id;
    }

    public function getCategoriaId() { 
        return $this->categoria_id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getStock() {
        return $this->stock;
    }

    public function getOferta() {
        return $this->oferta;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getImagen() {
        return $this->imagen;
    }

    //Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setCategoriaId($categoria_id) { 
        $this->categoria_id = $categoria_id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function setStock($stock) {
        $this->stock = $stock;
    }

    public function setOferta($oferta) {
        $this->oferta = $oferta;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    public function getAll(){
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

    public function save(){
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
            
            if($result) {
                $this->id = $this->db->lastInsertId();
                return true;
            }
            
            return false;
        } catch (\PDOException $e) {
            error_log("Error al guardar el producto: " . $e->getMessage());
            return false;
        }
    }
}
?>