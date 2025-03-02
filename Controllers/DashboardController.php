<?php
namespace Controllers;

require_once __DIR__ . '/../Models/Product.php';
require_once __DIR__ . '/../Models/Category.php';

class DashboardController {
    
    public function index() {
        // Obtener todas las categorías
        $categoryModel = new \Models\Category();
        $categories = $categoryModel->getAll();
        
        // Obtener un producto por cada categoría
        $productModel = new \Models\Product();
        $featuredProducts = [];
        
        foreach ($categories as $category) {
            // Obtenemos todos los productos de la categoría
            $productsInCategory = $productModel->getProductsByCategory($category['id']);
            
            // Si hay productos en esta categoría, tomamos el primero
            if (!empty($productsInCategory)) {
                $featuredProducts[] = $productsInCategory[0]; // Tomamos el primer producto (el más reciente)
            }
        }
        
        // Incluir las vistas
        require_once __DIR__ . '/../Views/layout/header.php';
        require_once __DIR__ . '/../Views/home/index.php';
        require_once __DIR__ . '/../Views/layout/footer.php';
    }
}