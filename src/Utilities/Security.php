<?php

namespace Utilities;

class Security
{
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function logout()
    {
        unset($_SESSION["login"]);
    }

    public static function login($userId, $userName, $userEmail, $userRol = null)
    {
        $_SESSION["login"] = array(
            "isLogged" => true,
            "userId" => $userId,
            "userName" => $userName,
            "userEmail" => $userEmail,
            "userRol" => $userRol
        );
    }

    public static function isLogged(): bool
    {
        return isset($_SESSION["login"]) &&
               $_SESSION["login"]["isLogged"];
    }

    public static function getUser()
    {
        if (isset($_SESSION["login"])) {
            return $_SESSION["login"];
        }
        return false;
    }

    public static function getUserId()
    {
        if (isset($_SESSION["login"])) {
            return $_SESSION["login"]["userId"];
        }
        return 0;
    }

    // id_rol del usuario logueado (1 = Administrador, 2 = Cliente).
    public static function getUserRol()
    {
        if (isset($_SESSION["login"])) {
            return $_SESSION["login"]["userRol"] ?? null;
        }
        return null;
    }

    // Solo el rol Administrador (id_rol = 1) tiene acceso administrativo.
    public static function isAdmin(): bool
    {
        return self::isLogged() && intval(self::getUserRol()) === 1;
    }

    // Menús que solo deben aparecer para el rol Administrador.
    private static $ADMIN_ONLY_MENUS = ["Menu_Pedidos", "Menu_Productos", "Menu_Categorias"];

    // Todos los usuarios autenticados tendrán acceso a las páginas privadas,
    // excepto los menús de administración, que exigen el rol Administrador.
    public static function isAuthorized($userId, $function, $type = 'FNC'): bool
    {
        if (!self::isLogged()) {
            return false;
        }

        if ($type === 'MNU' && in_array($function, self::$ADMIN_ONLY_MENUS, true)) {
            return self::isAdmin();
        }

        return true;
    }

    public static function isInRol($userId, $rol): bool
    {
        return self::isAdmin();
    }
}