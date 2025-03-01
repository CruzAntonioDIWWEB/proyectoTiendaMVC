<?php 
namespace Controllers;

    class ProductController {

        public function index() {
            require_once __DIR__ . '/../Views/layout/header.php';
            require_once __DIR__ . '/../Views/products/gestion.php';
            require_once __DIR__ . '/../Views/layout/footer.php';
        }

        public function gestion(){
            require_once __DIR__ . '/../Views/products/gestion.php';
        }
    }
?>