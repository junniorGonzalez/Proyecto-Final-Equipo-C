<?php

namespace Controllers\Checkout;

use Controllers\PrivateController;
use Views\Renderer;
use Utilities\Security;
use Dao\Pedidos as DaoPedidos;

class Historial extends PrivateController
{
    public function run(): void
    {
        $orders = DaoPedidos::getByUsuario(Security::getUserId());

        $viewData = [
            "titulo" => "Historial de compras",
            "orders" => $orders
        ];

        Renderer::render("checkout/historial", $viewData);
    }
}
