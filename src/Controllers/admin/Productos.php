<?php

namespace Controllers\Admin;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Productos as DaoProductos;

class Productos extends PublicController
{
    public function run(): void
    {
        $viewData = array();
        $viewData["productos"] = DaoProductos::getAll();

        Renderer::render("admin/productos", $viewData);
    }
}
