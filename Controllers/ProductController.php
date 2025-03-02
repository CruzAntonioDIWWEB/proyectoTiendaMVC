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

    /**
 * Muestra el formulario para editar un producto
 */
public function edit() {
    //Verifico si el usuario es administrador
    \Lib\Utils::isAdmin();
    
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        
        //Obtengo el producto
        $product = new \Models\Product();
        $productoEncontrado = $product->getOneProduct($id);
        
        //Obtengo categorías para el select
        $category = new \Models\Category();
        $categories = $category->getAll();
        
        if ($productoEncontrado) {
            //$productoEncontrado ahora es el objeto Product con los datos cargados
            require_once __DIR__ . '/../Views/layout/header.php';
            require_once __DIR__ . '/../Views/products/edit.php';
            require_once __DIR__ . '/../Views/layout/footer.php';
        } else {
            $_SESSION['product_error'] = "El producto no existe";
            header("Location: index.php?controller=product&action=gestion");
            exit();
        }
    } else {
        $_SESSION['product_error'] = "ID de producto no válido";
        header("Location: index.php?controller=product&action=gestion");
        exit();
    }
}

/**
 * Actualiza los datos de un producto
 */
public function update() {
    //Verifico si el usuario es administrador
    \Lib\Utils::isAdmin();
    
    if (isset($_POST) && !empty($_POST['nombre']) && !empty($_POST['descripcion']) && 
        !empty($_POST['precio']) && !empty($_POST['stock']) && !empty($_POST['categoria']) && isset($_POST['id'])) {
        
        $id = (int)$_POST['id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = floatval($_POST['precio']);
        $stock = intval($_POST['stock']);
        $categoria_id = intval($_POST['categoria']);
        
        //Obtengo el producto actual para verificar si hay imagen nueva
        $product = new \Models\Product();
        $product->getOneProduct($id);
        
        //Variable para controlar si se ha subido una nueva imagen
        $imagen_actualizada = false;
        
        //Verifico si se ha subido una nueva imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
            $file = $_FILES['imagen'];
            $filename = $file['name'];
            $mimetype = $file['type'];
            
            //Validación que sea una imagen
            if ($mimetype == "image/jpg" || $mimetype == "image/jpeg" || $mimetype == "image/png" || $mimetype == "image/gif") {
                //Se crea un directorio de imágenes si no existe
                if (!is_dir('uploads/images')) {
                    mkdir('uploads/images', 0777, true);
                }
                
                //Se mueve la imagen al directorio
                if (move_uploaded_file($file['tmp_name'], 'uploads/images/' . $filename)) {
                    $product->setImagen($filename);
                    $imagen_actualizada = true;
                } else {
                    $_SESSION['product_error'] = "Error al guardar la nueva imagen";
                    header("Location: index.php?controller=product&action=edit&id=$id");
                    exit();
                }
            } else {
                $_SESSION['product_error'] = "El formato de archivo no es válido";
                header("Location: index.php?controller=product&action=edit&id=$id");
                exit();
            }
        }
        
        //Actualizo los datos del producto
        $product->setId($id);
        $product->setCategoriaId($categoria_id);
        $product->setNombre($nombre);
        $product->setDescripcion($descripcion);
        $product->setPrecio($precio);
        $product->setStock($stock);
        
        //Se actualiza el producto
        $update = $product->update();
        
        if ($update) {
            $_SESSION['product'] = "El producto se ha actualizado correctamente";
        } else {
            $_SESSION['product_error'] = "Error al actualizar el producto";
        }
    } else {
        $_SESSION['product_error'] = "Faltan datos requeridos para actualizar el producto";
    }
    
    header("Location: index.php?controller=product&action=gestion");
    exit();
}

/**
 * Elimina un producto
 */
public function delete() {
    //Verifico si el usuario es administrador
    \Lib\Utils::isAdmin();
    
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        
        $product = new \Models\Product();
        $product->setId($id);
        
        //Obtener el producto para poder eliminar la imagen asociada
        $productoAEliminar = $product->getOneProduct($id);
        
        if ($productoAEliminar) {
            //Elimino el producto
            $delete = $product->delete();
            
            if ($delete) {
                //Si el producto se elimina, también eliminamos su imagen del servidor
                $rutaImagen = 'uploads/images/' . $productoAEliminar->getImagen();
                if (file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
                
                $_SESSION['product'] = "El producto se ha eliminado correctamente";
            } else {
                $_SESSION['product_error'] = "Error al eliminar el producto";
            }
        } else {
            $_SESSION['product_error'] = "El producto no existe";
        }
    } else {
        $_SESSION['product_error'] = "ID de producto no válido";
    }
    
    header("Location: index.php?controller=product&action=gestion");
    exit();
}

/**
 * Muestra los productos de una categoría específica
 */
public function category() {
    if (isset($_GET['id'])) {
        $categoria_id = (int)$_GET['id'];
        
        // Obtener los productos de la categoría
        $product = new \Models\Product();
        $products = $product->getProductsByCategory($categoria_id);
        
        // Obtener el nombre de la categoría para mostrarlo en la vista
        $category_name = $product->getCategoryName($categoria_id);
        
        // Cargar la vista
        require_once __DIR__ . '/../Views/layout/header.php';
        require_once __DIR__ . '/../Views/products/category.php';
        require_once __DIR__ . '/../Views/layout/footer.php';
    } else {
        // Si no se proporciona un ID de categoría, redirigir al inicio
        header("Location: index.php");
        exit();
    }
}

}
?>