<?php

namespace Controllers\Checkout;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Productos;
use Utilities\Site;

class Carrito extends PublicController
{
    public function run(): void
    {
        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = [];
        }

        if ($this->isPostBack()) {

            $accion = $_POST["action"] ?? "";

            if ($accion == "ADD") {

                $prdcod = intval($_POST["prdcod"]);

                $producto = Productos::getById($prdcod);

                if ($producto) {

                    if (isset($_SESSION["cart"][$prdcod])) {

                        $_SESSION["cart"][$prdcod]["cantidad"]++;

                    } else {

                        $producto["cantidad"] = 1;

                        $_SESSION["cart"][$prdcod] = $producto;
                    }
                }

                Site::redirectTo("index.php?page=Checkout_Catalogo");
            }

            if ($accion == "PLUS") {

                $prdcod = intval($_POST["prdcod"]);

                if (isset($_SESSION["cart"][$prdcod])) {

                    $_SESSION["cart"][$prdcod]["cantidad"]++;
                }

                Site::redirectTo("index.php?page=Checkout_Carrito");
            }

            if ($accion == "MINUS") {

                $prdcod = intval($_POST["prdcod"]);

                if (isset($_SESSION["cart"][$prdcod])) {

                    $_SESSION["cart"][$prdcod]["cantidad"]--;

                    if ($_SESSION["cart"][$prdcod]["cantidad"] <= 0) {

                        unset($_SESSION["cart"][$prdcod]);
                    }
                }

                Site::redirectTo("index.php?page=Checkout_Carrito");
            }

            if ($accion == "DELETE") {

                $prdcod = intval($_POST["prdcod"]);

                if (isset($_SESSION["cart"][$prdcod])) {

                    unset($_SESSION["cart"][$prdcod]);
                }

                Site::redirectTo("index.php?page=Checkout_Carrito");
            }

            if ($accion == "CLEAR") {

    $_SESSION["cart"] = [];

    Site::redirectTo("index.php?page=Checkout_Carrito");
}
        }

        $total = 0;

        foreach ($_SESSION["cart"] as &$producto) {

            $producto["subtotal"] = $producto["prdcosto"] * $producto["cantidad"];

            $total += $producto["subtotal"];
        }

        $viewData = [
            "titulo" => "Carrito de Compras",
            "carrito" => $_SESSION["cart"],
            "total" => $total
        ];


        Site::addLink("public/css/carrito.css");
        Renderer::render("checkout/carrito", $viewData);
    }
}