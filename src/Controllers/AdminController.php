<?php
/**
 * Base Controller para páginas de administración.
 * Exige que el usuario haya iniciado sesión (heredado de PrivateController)
 * y además que su rol sea Administrador.
 */
namespace Controllers;

abstract class AdminController extends PrivateController
{
    public function __construct()
    {
        parent::__construct();

        if (!\Utilities\Security::isAdmin()) {
            throw new PrivateNoAuthException();
        }
    }
}
