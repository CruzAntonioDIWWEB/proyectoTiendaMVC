<?php 
namespace Controllers;

require_once __DIR__ . '/../Lib/Utils.php';
require_once __DIR__ . '/../Models/Product.php';
require_once __DIR__ . '/../Models/Category.php';

class ProductController {

    public function index() {
        //Obtengo todos los productos
        $product = new \Models\Product();
        $products = $product->getAll();
    
        require_once __DIR__ . '/../Views/layout/header.php';
        require_once __DIR__ . '/../Views/products/gestion.php'; 
        require_once __DIR__ . '/../Views/layout/footer.php';
    }

    public function gestion(){
        //Verifico si el usuario es administrador
        \Lib\Utils::isAdmin();
    
        //Obtengo todos los productos
        $product = new \Models\Product();
        $products = $product->getAll();
        
        //Depuración para ver si hay productos
        error_log("Número de productos obtenidos: " . count($products));
    
        require_once __DIR__ . '/../Views/layout/header.php';
        require_once __DIR__ . '/../Views/products/gestion.php';
        require_once __DIR__ . '/../Views/layout/footer.php';
    }

    public function create() {
        //Verifico si el usuario es administrador
        \Lib\Utils::isAdmin();

        //Obtener categorías para el select
        $category = new \Models\Category();
        $categories = $category->getAll();

        require_once __DIR__ . '/../Views/layout/header.php';
        require_once __DIR__ . '/../Views/products/create.php';
        require_once __DIR__ . '/../Views/layout/footer.php';
    }

    public function save(){
        //Verifico si el usuario es administrador
        \Lib\Utils::isAdmin();
        
        if(isset($_POST) && !empty($_POST['nombre']) && !empty($_POST['descripcion']) && 
           !empty($_POST['precio']) && !empty($_POST['stock']) && !empty($_POST['categoria'])) {
            
            //Verifico primero si hay una imagen subida
            if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
                
                //Valido datos
                $nombre = $_POST['nombre'];
                $descripcion = $_POST['descripcion'];
                $precio = floatval($_POST['precio']);
                $stock = intval($_POST['stock']);
                $categoria_id = intval($_POST['categoria']);
                
                //Manejo de la imagen
                $file = $_FILES['imagen'];
                $filename = $file['name'];
                $mimetype = $file['type'];
                
                //Validación que sea una imagen
                if($mimetype == "image/jpg" || $mimetype == "image/jpeg" || $mimetype == "image/png" || $mimetype == "image/gif") {
                    
                    //Se crea un directorio de imágenes si no existe
                    if(!is_dir('uploads/images')){
                        mkdir('uploads/images', 0777, true);
                    }
                    
                    //Se mueve la imagen al directorio
                    if(move_uploaded_file($file['tmp_name'], 'uploads/images/'.$filename)){
                        
                        //Y se guarda en la base de datos
                        $product = new \Models\Product();
                        $product->setCategoriaId($categoria_id); 
                        $product->setNombre($nombre);
                        $product->setDescripcion($descripcion);
                        $product->setPrecio($precio);
                        $product->setStock($stock);
                        $product->setImagen($filename);
                        
                        $save = $product->save();
                        
                        if($save){
                            $_SESSION['product'] = "El producto se ha guardado correctamente";
                        } else {
                            $_SESSION['product_error'] = "Error al guardar el producto en la base de datos";
                        }
                    } else {
                        $_SESSION['product_error'] = "Error al guardar la imagen";
                    }
                } else {
                    $_SESSION['product_error'] = "El formato de archivo no es válido";
                }
            } else {
                $_SESSION['product_error'] = "La imagen es obligatoria";
            }
        } else {
            $_SESSION['product_error'] = "Rellena todos los campos del formulario";
        }
        
        header("Location: index.php?controller=product&action=gestion");
        exit();
    }
}
?>