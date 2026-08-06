<?php

namespace Controllers\Checkout;

use Controllers\PrivateController;
use Views\Renderer;
use Dao\Productos;
use Utilities\Site;

class Carrito extends PrivateController
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

                    if ($producto["prdest"] === "No disponible") {
                        Site::redirectTo("index.php?page=Checkout_Catalogo#prod-" . $prdcod);
                    }

                    if (isset($_SESSION["cart"][$prdcod])) {

                        $_SESSION["cart"][$prdcod]["cantidad"]++;

                    } else {

                        $producto["cantidad"] = 1;

                        $_SESSION["cart"][$prdcod] = $producto;
                    }
                }

                Site::redirectTo("index.php?page=Checkout_Catalogo#prod-" . $prdcod);
            }

            if ($accion == "PLUS") {

                $prdcod = intval($_POST["prdcod"]);

                if (isset($_SESSION["cart"][$prdcod])) {

                    $_SESSION["cart"][$prdcod]["cantidad"]++;
                }

                Site::redirectTo("index.php?page=Checkout_Carrito#cart-" . $prdcod);
            }

            if ($accion == "MINUS") {

                $prdcod = intval($_POST["prdcod"]);

                if (isset($_SESSION["cart"][$prdcod])) {

                    $_SESSION["cart"][$prdcod]["cantidad"]--;

                    if ($_SESSION["cart"][$prdcod]["cantidad"] <= 0) {

                        unset($_SESSION["cart"][$prdcod]);
                    }
                }

                Site::redirectTo("index.php?page=Checkout_Carrito#cart-" . $prdcod);
            }

            if ($accion == "DELETE") {

                $prdcod = intval($_POST["prdcod"]);

                if (isset($_SESSION["cart"][$prdcod])) {

                    unset($_SESSION["cart"][$prdcod]);
                }

                Site::redirectTo("index.php?page=Checkout_Carrito#carrito");
            }
        }

        foreach ($_SESSION["cart"] as $prdcod => $producto) {
            $currentProduct = Productos::getById(intval($prdcod));
            if (!$currentProduct || $currentProduct["prdest"] === "No disponible") {
                unset($_SESSION["cart"][$prdcod]);
                continue;
            }
            // Keep cart values in sync with current product state
            $_SESSION["cart"][$prdcod] = array_merge($currentProduct, [
                "cantidad" => $producto["cantidad"]
            ]);
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