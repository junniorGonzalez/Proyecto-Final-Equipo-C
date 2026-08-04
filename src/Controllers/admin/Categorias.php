<?php

namespace Controllers\Admin;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Categorias as DaoCategorias;

class Categorias extends PublicController
{
    public function run(): void
    {
        $viewData = array();
        $viewData["categorias"] = DaoCategorias::getAll();

        Renderer::render("admin/categorias", $viewData);
    }
}
