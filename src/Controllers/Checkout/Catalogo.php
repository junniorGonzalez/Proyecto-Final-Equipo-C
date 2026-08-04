<?php

namespace Controllers\Checkout;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Productos;

class Catalogo extends PublicController
{
    public function run(): void
    {
        $productos = Productos::getAll();
        $viewData = [
            "productos" => $productos,
            "titulo" => "Catálogo La Neverita"
        ];
        Renderer::render("checkout/catalogo", $viewData);
    }
}
