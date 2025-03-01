<?php
namespace Controllers;

require_once __DIR__ . '/../Models/Category.php';
require_once __DIR__ . '/../Lib/Utils.php';

class CategoryController {
    
    /**
     * Muestra la lista de categorías
     */
    public function index() {
        //Obtengo todas las categorías
        $categoria = new \Models\Category();
        $categorias = $categoria->getAll();
        
        require_once __DIR__ . '/../Views/layout/header.php';
        require_once __DIR__ . '/../Views/category/index.php';
        require_once __DIR__ . '/../Views/layout/footer.php';
    }
    
    /**
     * Muestra el formulario para crear una categoría
     */
    public function create() {
        //Primero verifico si el usuario es administrador
        if (\Lib\Utils::isAdmin()) {
            require_once __DIR__ . '/../Views/layout/header.php';
            require_once __DIR__ . '/../Views/category/create.php';
            require_once __DIR__ . '/../Views/layout/footer.php';
        } else {
            //Si no es administrador, redirijo al inicio
            header("Location: index.php");
            exit();
        }
    }
    
    /**
     * Guarda una nueva categoría
     */
    public function save() {
        //Verifico si el usuario es administrador
        if (\Lib\Utils::isAdmin()) {
            if (isset($_POST) && !empty($_POST['nombre'])) {
                //Creo una categoría
                $categoria = new \Models\Category();
                
                //Y verifico si ya existe una categoría con ese nombre
                if ($categoria->checkCategoryExists($_POST['nombre'])) {
                    $_SESSION['category_error'] = "Ya existe una categoría con ese nombre";
                    header("Location: index.php?controller=category&action=create");
                    exit();
                }
                
                //Asigno el nombre de la categoria
                $categoria->setNombre($_POST['nombre']);
                
                //Guardo la categoría
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
        //Verifico si el usuario es administrador
        if (\Lib\Utils::isAdmin()) {
            if (isset($_GET['id'])) {
                $id = (int)$_GET['id'];
                
                //Obtengo la categoría
                $categoria = new \Models\Category();
                $categoriaEncontrada = $categoria->getOneCategory($id);
                
                if ($categoriaEncontrada) {
                    //$categoriaEncontrada ahora es el objeto Category con los datos cargados
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
            //Si no es administrador, se redirige al inicio
            header("Location: index.php");
            exit();
        }
    }
    
    /**
     * Actualiza los datos de una categoría
     */
    public function update() {
        //Verifico si el usuario es administrador
        if (\Lib\Utils::isAdmin()) {
            if (isset($_POST) && !empty($_POST['nombre']) && isset($_POST['id'])) {
                $id = (int)$_POST['id'];
                $nombre = $_POST['nombre'];
                
                $categoria = new \Models\Category();
                
                //Verifico si ya existe otra categoría con ese nombre
                if ($categoria->checkCategoryExistsExcept($nombre, $id)) {
                    $_SESSION['category_error'] = "Ya existe otra categoría con ese nombre";
                    header("Location: index.php?controller=category&action=edit&id=$id");
                    exit();
                }
                
                //Asino nombre e id
                $categoria->setId($id);
                $categoria->setNombre($nombre);
                
                //Actualiza la categoría
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
        if (\Lib\Utils::isAdmin()) {
            if (isset($_GET['id'])) {
                $id = (int)$_GET['id'];
                
                $categoria = new \Models\Category();
                $categoria->setId($id);
                
                //Elimino la categoría
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