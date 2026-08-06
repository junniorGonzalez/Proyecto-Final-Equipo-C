<?php

namespace Controllers\Checkout;

use Controllers\PrivateController;
use Views\Renderer;
use Utilities\Context;
use Utilities\Security;
use Utilities\Site;
use Dao\Pedidos as DaoPedidos;
use Dao\Usuario as DaoUsuario;

class Pago extends PrivateController
{
    public function run(): void
    {
        if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
            Site::redirectTo("index.php?page=Checkout_Catalogo");
        }

        $total = 0;

        foreach ($_SESSION["cart"] as &$producto) {
            $producto["subtotal"] = $producto["prdcosto"] * $producto["cantidad"];
            $total += $producto["subtotal"];
        }

        $usuario = DaoUsuario::buscarPorId(Security::getUserId());
        $direccionEntrega = trim($_POST["direccion_entrega"] ?? ($usuario["direccion"] ?? ""));

        $viewData = [
            "titulo" => "Finalizar compra",
            "carrito" => $_SESSION["cart"],
            "total" => $total,
            "error" => $_SESSION["paypal_error"] ?? "",
            "direccion_entrega" => $direccionEntrega
        ];

        if ($this->isPostBack()) {
            unset($_SESSION["paypal_error"]);

            if ($direccionEntrega === "") {
                $viewData["error"] = "Debes indicar una dirección de entrega para continuar.";
                Renderer::render("checkout/pago", $viewData);
                return;
            }

            $clientId = trim(Context::getContextByKey("PAYPAL_CLIENT_ID"));
            $clientSecret = trim(Context::getContextByKey("PAYPAL_CLIENT_SECRET"));
            $useDemoMode = $clientId === "" || $clientSecret === "" || strtolower($clientId) === "demo" || strtolower($clientSecret) === "demo";

            if ($useDemoMode) {
                $orderId = "demo-" . time();

                $this->crearPedido($direccionEntrega, $total, $orderId, "PayPal Sandbox");

                $_SESSION["paypal_mode"] = "demo";
                $_SESSION["paypal_order_id"] = $orderId;
                $_SESSION["cart"] = [];
                Site::redirectTo("index.php?page=Checkout_Accept&token=" . urlencode($orderId));
            }

            $paypalOrder = new \Utilities\Paypal\PayPalOrder(
                "neverita-" . time(),
                $this->buildUrl("Checkout_Error"),
                $this->buildUrl("Checkout_Accept")
            );

            foreach ($_SESSION["cart"] as $item) {
                $paypalOrder->addItem(
                    $item["prddsc"],
                    $item["descripcion"] ?? "Producto La Neverita",
                    "PRD" . $item["prdcod"],
                    round((float) $item["prdcosto"], 2),
                    0,
                    (int) $item["cantidad"],
                    $item["prdcategoria"] ?? "SNACKS"
                );
            }

            $paypalRestApi = new \Utilities\PayPal\PayPalRestApi($clientId, $clientSecret, "sandbox");
            $response = $paypalRestApi->createOrder($paypalOrder);

            if (!isset($response->id)) {
                $_SESSION["paypal_error"] = "No se pudo crear la orden en PayPal. Revisa tus credenciales.";
                $viewData["error"] = $_SESSION["paypal_error"];
                Renderer::render("checkout/pago", $viewData);
                return;
            }

            $this->crearPedido($direccionEntrega, $total, $response->id, "PayPal Sandbox");

            $_SESSION["paypal_order_id"] = $response->id;
            $_SESSION["paypal_mode"] = "live";
            $_SESSION["cart"] = [];

            foreach ($response->links as $link) {
                if ($link->rel === "approve") {
                    Site::redirectTo($link->href);
                }
            }

            $_SESSION["paypal_error"] = "PayPal no devolvió un enlace de aprobación.";
            $viewData["error"] = $_SESSION["paypal_error"];
            Renderer::render("checkout/pago", $viewData);
            return;
        }

        Renderer::render("checkout/pago", $viewData);
    }

    private function crearPedido(string $direccionEntrega, float $total, string $referenciaPago, string $metodoPago): void
    {
        $items = [];

        foreach ($_SESSION["cart"] as $item) {
            $items[] = [
                "id_producto" => (int) $item["prdcod"],
                "cantidad" => (int) $item["cantidad"],
                "precio" => round((float) $item["prdcosto"], 2),
                "subtotal" => round((float) $item["prdcosto"] * (int) $item["cantidad"], 2)
            ];
        }

        DaoPedidos::crear(
            Security::getUserId(),
            $direccionEntrega,
            round($total, 2),
            $items,
            $metodoPago,
            $referenciaPago
        );
    }

    private function buildUrl(string $page): string
    {
        $baseDir = trim(Context::getContextByKey("BASE_DIR"), "/");
        $host = $_SERVER["HTTP_HOST"] ?? "localhost:8080";
        $scheme = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") ? "https" : "http";

        if ($baseDir !== "") {
            return $scheme . "://" . $host . "/" . $baseDir . "/index.php?page=" . $page;
        }

        return $scheme . "://" . $host . "/index.php?page=" . $page;
    }
}
