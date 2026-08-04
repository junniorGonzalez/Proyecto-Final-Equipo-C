<?php

namespace Controllers\Checkout;

use Controllers\PublicController;
use Views\Renderer;

class Historial extends PublicController
{
    public function run(): void
    {
        $orders = $_SESSION["orders"] ?? [];

        $viewData = [
            "titulo" => "Historial de compras",
            "orders" => array_reverse($orders)
        ];

        Renderer::render("checkout/historial", $viewData);
    }
}
