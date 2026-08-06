<?php

namespace Controllers\Admin;

use Controllers\AdminController;
use Views\Renderer;
use Dao\Productos as DaoProductos;

class Productos extends AdminController
{
    public function run(): void
    {
        $viewData = array();
        $viewData["productos"] = DaoProductos::getAll();

        Renderer::render("admin/productos", $viewData);
    }
}
