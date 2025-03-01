<?php 
namespace Controllers;

require_once __DIR__ . '/../Lib/Utils.php';
require_once __DIR__ . '/../Models/Product.php';

    class ProductController {

        public function index() {
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

            require_once __DIR__ . '/../Views/products/gestion.php';
        }
    }
?>