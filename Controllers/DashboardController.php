<?php

namespace Controllers;

require_once __DIR__ . '/../Models/Product.php';
require_once __DIR__ . '/../Models/Category.php';

class DashboardController
{

    public function index()
    {
        //Obtengo todas las categorías
        $categoryModel = new \Models\Category();
        $categories = $categoryModel->getAll();

        //Obtengo un producto por cada categoría
        $productModel = new \Models\Product();
        $featuredProducts = [];

        foreach ($categories as $category) {
            //Se recogen todos los productos de la categoría
            $productsInCategory = $productModel->getProductsByCategory($category['id']);

            //Y si hay productos en esta categoría se muestra el primero (el añadido más reciente)
            if (!empty($productsInCategory)) {
                $featuredProducts[] = $productsInCategory[0];
            }
        }

        require_once __DIR__ . '/../Views/layout/header.php';
        require_once __DIR__ . '/../Views/home/index.php';
        require_once __DIR__ . '/../Views/layout/footer.php';
    }
}
