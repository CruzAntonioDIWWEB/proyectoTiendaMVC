<?php
namespace Controllers;

require_once __DIR__ . '/../Models/Category.php';
require_once __DIR__ . '/../Lib/Utils.php';

class CategoryController {
    
    /**
     * Muestra la lista de categorías
     */
    public function index() {
        // Obtener todas las categorías
        $categoria = new \Models\Category();
        $categorias = $categoria->getAll();
        
        // Incluir las vistas
        require_once __DIR__ . '/../Views/layout/header.php';
        require_once __DIR__ . '/../Views/category/index.php';
        require_once __DIR__ . '/../Views/layout/footer.php';
    }
    
    /**
     * Muestra el formulario para crear una categoría
     */
    public function create() {
        // Verificar si el usuario es administrador
        if (\Lib\Utils::isAdmin()) {
            require_once __DIR__ . '/../Views/layout/header.php';
            require_once __DIR__ . '/../Views/category/create.php';
            require_once __DIR__ . '/../Views/layout/footer.php';
        } else {
            // Si no es administrador, redirigir al inicio
            header("Location: index.php");
            exit();
        }
    }
    
    /**
     * Guarda una nueva categoría
     */
    public function save() {
        // Verificar si el usuario es administrador
        if (\Lib\Utils::isAdmin()) {
            if (isset($_POST) && !empty($_POST['nombre'])) {
                // Crear objeto categoría
                $categoria = new \Models\Category();
                
                // Verificar si ya existe una categoría con ese nombre
                if ($categoria->checkCategoryExists($_POST['nombre'])) {
                    $_SESSION['category_error'] = "Ya existe una categoría con ese nombre";
                    header("Location: index.php?controller=category&action=create");
                    exit();
                }
                
                // Asignar valores
                $categoria->setNombre($_POST['nombre']);
                $categoria->setDescripcion(isset($_POST['descripcion']) ? $_POST['descripcion'] : '');
                
                // Guardar la categoría
                $save = $categoria->save();
                
                if ($save) {
                    $_SESSION['category'] = "La categoría se ha guardado correctamente";
                } else {
                    $_SESSION['category_error'] = "Error al guardar la categoría";
                }
            } else {
                $_SESSION['category_error'] = "El nombre de la categoría es obligatorio";
            }
        } else {
            $_SESSION['category_error'] = "No tienes permisos para crear categorías";
        }
        
        header("Location: index.php?controller=category&action=index");
        exit();
    }
    
    /**
     * Muestra el formulario para editar una categoría
     */
    public function edit() {
        // Verificar si el usuario es administrador
        if (\Lib\Utils::isAdmin()) {
            if (isset($_GET['id'])) {
                $id = (int)$_GET['id'];
                
                // Obtener la categoría
                $categoria = new \Models\Category();
                $categoria = $categoria->getOne($id);
                
                if ($categoria) {
                    require_once __DIR__ . '/../Views/layout/header.php';
                    require_once __DIR__ . '/../Views/category/edit.php';
                    require_once __DIR__ . '/../Views/layout/footer.php';
                } else {
                    $_SESSION['category_error'] = "La categoría no existe";
                    header("Location: index.php?controller=category&action=index");
                    exit();
                }
            } else {
                $_SESSION['category_error'] = "ID de categoría no válido";
                header("Location: index.php?controller=category&action=index");
                exit();
            }
        } else {
            // Si no es administrador, redirigir al inicio
            header("Location: index.php");
            exit();
        }
    }
    
    /**
     * Actualiza los datos de una categoría
     */
    public function update() {
        // Verificar si el usuario es administrador
        if (\Lib\Utils::isAdmin()) {
            if (isset($_POST) && !empty($_POST['nombre']) && isset($_POST['id'])) {
                $id = (int)$_POST['id'];
                $nombre = $_POST['nombre'];
                
                // Crear objeto categoría
                $categoria = new \Models\Category();
                
                // Verificar si ya existe otra categoría con ese nombre
                if ($categoria->checkCategoryExistsExcept($nombre, $id)) {
                    $_SESSION['category_error'] = "Ya existe otra categoría con ese nombre";
                    header("Location: index.php?controller=category&action=edit&id=$id");
                    exit();
                }
                
                // Asignar valores
                $categoria->setId($id);
                $categoria->setNombre($nombre);
                $categoria->setDescripcion(isset($_POST['descripcion']) ? $_POST['descripcion'] : '');
                
                // Actualizar la categoría
                $update = $categoria->update();
                
                if ($update) {
                    $_SESSION['category'] = "La categoría se ha actualizado correctamente";
                } else {
                    $_SESSION['category_error'] = "Error al actualizar la categoría";
                }
            } else {
                $_SESSION['category_error'] = "El nombre de la categoría es obligatorio";
            }
        } else {
            $_SESSION['category_error'] = "No tienes permisos para editar categorías";
        }
        
        header("Location: index.php?controller=category&action=index");
        exit();
    }
    
    /**
     * Elimina una categoría
     */
    public function delete() {
        // Verificar si el usuario es administrador
        if (\Lib\Utils::isAdmin()) {
            if (isset($_GET['id'])) {
                $id = (int)$_GET['id'];
                
                // Crear objeto categoría
                $categoria = new \Models\Category();
                $categoria->setId($id);
                
                // Eliminar la categoría
                $delete = $categoria->delete();
                
                if ($delete) {
                    $_SESSION['category'] = "La categoría se ha eliminado correctamente";
                } else {
                    $_SESSION['category_error'] = "Error al eliminar la categoría";
                }
            } else {
                $_SESSION['category_error'] = "ID de categoría no válido";
            }
        } else {
            $_SESSION['category_error'] = "No tienes permisos para eliminar categorías";
        }
        
        header("Location: index.php?controller=category&action=index");
        exit();
    }
}