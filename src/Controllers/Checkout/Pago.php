<?php

namespace Controllers\Checkout;

use Controllers\PublicController;
use Views\Renderer;
use Utilities\Context;
use Utilities\Site;

class Pago extends PublicController
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

        $viewData = [
            "titulo" => "Finalizar compra",
            "carrito" => $_SESSION["cart"],
            "total" => $total,
            "error" => $_SESSION["paypal_error"] ?? ""
        ];

        if ($this->isPostBack()) {
            unset($_SESSION["paypal_error"]);

            $clientId = trim(Context::getContextByKey("PAYPAL_CLIENT_ID"));
            $clientSecret = trim(Context::getContextByKey("PAYPAL_CLIENT_SECRET"));
            $useDemoMode = $clientId === "" || $clientSecret === "" || strtolower($clientId) === "demo" || strtolower($clientSecret) === "demo";

            if ($useDemoMode) {
                $orderId = "demo-" . time();
                $this->saveOrder([
                    "id" => $orderId,
                    "status" => "PENDIENTE",
                    "payment_status" => "PENDING",
                    "payment_method" => "PayPal Sandbox",
                    "total" => round($total, 2),
                    "items" => $this->buildItemsSummary($_SESSION["cart"]),
                    "created_at" => date("Y-m-d H:i:s"),
                    "usuario" => $_SESSION["usuario_nombre"] ?? "Cliente"
                ]);

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

            $this->saveOrder([
                "id" => $response->id,
                "status" => "PENDIENTE",
                "payment_status" => "PENDING",
                "payment_method" => "PayPal Sandbox",
                "total" => round($total, 2),
                "items" => $this->buildItemsSummary($_SESSION["cart"]),
                "created_at" => date("Y-m-d H:i:s"),
                "usuario" => $_SESSION["usuario_nombre"] ?? "Cliente"
            ]);

            $_SESSION["paypal_order_id"] = $response->id;
            $_SESSION["paypal_mode"] = "live";

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

    private function saveOrder(array $orderData): void
    {
        if (!isset($_SESSION["orders"]) || !is_array($_SESSION["orders"])) {
            $_SESSION["orders"] = [];
        }

        $_SESSION["orders"][] = $orderData;
    }

    private function buildItemsSummary(array $cart): array
    {
        $items = [];

        foreach ($cart as $item) {
            $items[] = [
                "nombre" => $item["prddsc"],
                "cantidad" => (int) ($item["cantidad"] ?? 1),
                "precio" => round((float) ($item["prdcosto"] ?? 0), 2),
                "subtotal" => round((float) ($item["prdcosto"] ?? 0) * (int) ($item["cantidad"] ?? 1), 2)
            ];
        }

        return $items;
    }
}
