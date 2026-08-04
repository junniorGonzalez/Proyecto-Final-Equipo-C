<?php

namespace Controllers\Checkout;

use Controllers\PublicController;
use Utilities\Context;

class Accept extends PublicController
{
    public function run(): void
    {
        $dataview = array();
        $token = $_GET["token"] ?? "";
        $session_token = $_SESSION["paypal_order_id"] ?? "";

        if ($token !== "" && $token === $session_token) {
            $mode = $_SESSION["paypal_mode"] ?? "demo";
            $order = $this->findOrderById($session_token);

            //metodo de pago

            if ($mode === "demo") {
                if ($order !== null) {
                    $order["status"] = "COMPLETADO";
                    $order["payment_status"] = "APPROVED";
                    $this->updateOrder($session_token, $order);
                }

                $result = [
                    "status" => "COMPLETED",
                    "mode" => "demo",
                    "message" => "Pago completado correctamente.",
                    "order_id" => $session_token,
                    "estado" => "COMPLETADO"
                ];
                $dataview["orderjson"] = json_encode($result, JSON_PRETTY_PRINT);
                $dataview["order_id"] = $session_token;
                $dataview["total"] = $order["total"] ?? 0;
                $dataview["items"] = $order["items"] ?? [];
                $dataview["payment_method"] = $order["payment_method"] ?? "PayPal Sandbox";
            } else {
                $clientId = trim(Context::getContextByKey("PAYPAL_CLIENT_ID"));
                $clientSecret = trim(Context::getContextByKey("PAYPAL_CLIENT_SECRET"));

                if ($clientId !== "" && $clientSecret !== "") {
                    $PayPalRestApi = new \Utilities\PayPal\PayPalRestApi($clientId, $clientSecret, "sandbox");
                    $result = $PayPalRestApi->captureOrder($session_token);

                    if ($order !== null) {
                        $order["status"] = isset($result->status) && $result->status === "COMPLETED" ? "COMPLETADO" : "PENDIENTE";
                        $order["payment_status"] = isset($result->status) ? $result->status : "PENDING";
                        $this->updateOrder($session_token, $order);
                    }

                    $dataview["orderjson"] = json_encode($result, JSON_PRETTY_PRINT);
                    $dataview["order_id"] = $session_token;
                    $dataview["total"] = $order["total"] ?? 0;
                    $dataview["items"] = $order["items"] ?? [];
                    $dataview["payment_method"] = $order["payment_method"] ?? "PayPal Sandbox";
                } else {
                    $dataview["orderjson"] = "PayPal no está configurado. Agrega tus credenciales en parameters.env.";
                    $dataview["total"] = 0;
                    $dataview["items"] = [];
                }
            }
        } else {
            $dataview["orderjson"] = "No Order Available!!!";
            $dataview["total"] = 0;
            $dataview["items"] = [];
        }

        \Views\Renderer::render("paypal/accept", $dataview);
    }

    private function findOrderById(string $orderId): ?array
    {
        if (!isset($_SESSION["orders"]) || !is_array($_SESSION["orders"])) {
            return null;
        }

        foreach ($_SESSION["orders"] as $order) {
            if (($order["id"] ?? "") === $orderId) {
                return $order;
            }
        }

        return null;
    }

    private function updateOrder(string $orderId, array $orderData): void
    {
        if (!isset($_SESSION["orders"]) || !is_array($_SESSION["orders"])) {
            return;
        }

        foreach ($_SESSION["orders"] as $index => $order) {
            if (($order["id"] ?? "") === $orderId) {
                $_SESSION["orders"][$index] = $orderData;
                return;
            }
        }
    }
}
