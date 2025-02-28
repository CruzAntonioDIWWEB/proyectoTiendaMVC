<?php

namespace Lib;

class Utils
{
    /**
     * Verifica si el usuario actual es administrador
     * @return bool true si es administrador, false si no
     */
    public static function isAdmin()
    {
        if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] == 'admin') {
            return true;
        }
        return false;
    }

    /**
     * Verifica si el usuario está identificado
     * @return bool true si está identificado, false si no
     */
    public static function isIdentity()
    {
        if (isset($_SESSION['usuario'])) {
            return true;
        }
        return false;
    }

    /**
     * Elimina todas las sesiones de categoría
     */
    public static function deleteSession($name)
    {
        if (isset($_SESSION[$name])) {
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }

        return $name;
    }

    /**
     * Obtiene todas las categorías para mostrar en el menú
     * @return array Array con las categorías
     */
    public static function getCategoriesMenu()
    {
        require_once __DIR__ . '/../Models/Category.php';
        $categoria = new \Models\Category();
        return $categoria->getAll();
    }
}
