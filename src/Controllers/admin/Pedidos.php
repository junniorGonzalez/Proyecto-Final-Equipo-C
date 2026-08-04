<?php

namespace Controllers\admin;

use Controllers\PrivateController;
use Views\Renderer;

class Pedidos extends PrivateController
{
    public function run(): void
    {
        if (!isset($_SESSION["orders"]) || !is_array($_SESSION["orders"])) {
            $_SESSION["orders"] = [];
        }

        // Actualizar estado
        if ($this->isPostBack()) {

            $id = $_POST["id"] ?? "";
            $status = $_POST["status"] ?? "PENDIENTE";

            foreach ($_SESSION["orders"] as $index => $order) {

                if (($order["id"] ?? "") === $id) {

                    $_SESSION["orders"][$index]["status"] = $status;
                    $_SESSION["orders"][$index]["payment_status"] = $status;

                    break;
                }
            }
        }

        // Los pedidos antiguos que no tengan estado
        foreach ($_SESSION["orders"] as $index => $order) {

            if (
                !isset($_SESSION["orders"][$index]["status"]) ||
                $_SESSION["orders"][$index]["status"] == ""
            ) {

                $_SESSION["orders"][$index]["status"] = "PENDIENTE";
            }

            $_SESSION["orders"][$index]["selected_pendiente"] =
                ($_SESSION["orders"][$index]["status"] == "PENDIENTE") ? "selected" : "";

            $_SESSION["orders"][$index]["selected_preparando"] =
                ($_SESSION["orders"][$index]["status"] == "PREPARANDO") ? "selected" : "";

            $_SESSION["orders"][$index]["selected_camino"] =
                ($_SESSION["orders"][$index]["status"] == "EN CAMINO") ? "selected" : "";

            $_SESSION["orders"][$index]["selected_entregado"] =
                ($_SESSION["orders"][$index]["status"] == "ENTREGADO") ? "selected" : "";
        }

        $viewData = [
            "titulo" => "Administración de Pedidos",
            "orders" => array_reverse($_SESSION["orders"])
        ];

        Renderer::render("admin/pedidos", $viewData);
    }
}