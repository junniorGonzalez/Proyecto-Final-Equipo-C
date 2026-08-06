<?php

namespace Controllers\admin;

use Controllers\AdminController;
use Views\Renderer;
use Dao\Pedidos as DaoPedidos;

class Pedidos extends AdminController
{
    public function run(): void
    {
        if ($this->isPostBack()) {
            $idPedido = intval($_POST["id"] ?? 0);
            $status = $_POST["status"] ?? "Pendiente";

            if ($idPedido > 0) {
                DaoPedidos::actualizarEstadoEnvio($idPedido, $status);
            }
        }

        $orders = DaoPedidos::getAll();

        foreach ($orders as &$order) {
            $order["cliente"] = trim(($order["cliente_nombre"] ?? "") . " " . ($order["cliente_apellido"] ?? ""));

            foreach (DaoPedidos::$ESTADOS as $estado) {
                $key = "selected_" . strtolower(str_replace(" ", "_", $estado));
                $order[$key] = ($order["estado"] === $estado) ? "selected" : "";
            }
        }
        unset($order);

        $viewData = [
            "titulo" => "Administración de Pedidos",
            "orders" => $orders
        ];

        Renderer::render("admin/pedidos", $viewData);
    }
}
