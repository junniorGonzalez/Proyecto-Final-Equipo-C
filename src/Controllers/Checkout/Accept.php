<?php

namespace Controllers\Checkout;

use Controllers\PrivateController;
use Utilities\Context;
use Dao\Pedidos as DaoPedidos;

class Accept extends PrivateController
{
    public function run(): void
    {
        $dataview = array();
        $token = $_GET["token"] ?? "";
        $session_token = $_SESSION["paypal_order_id"] ?? "";

        if ($token !== "" && $token === $session_token) {
            $mode = $_SESSION["paypal_mode"] ?? "demo";
            $pedido = DaoPedidos::getByReferencia($session_token);

            if ($mode === "demo") {
                if ($pedido !== null) {
                    DaoPedidos::marcarPago($session_token, "Pagado");
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
                $dataview["total"] = $pedido["total"] ?? 0;
                $dataview["items"] = $pedido["items"] ?? [];
                $dataview["payment_method"] = $pedido["metodo_pago"] ?? "PayPal Sandbox";
            } else {
                $clientId = trim(Context::getContextByKey("PAYPAL_CLIENT_ID"));
                $clientSecret = trim(Context::getContextByKey("PAYPAL_CLIENT_SECRET"));

                if ($clientId !== "" && $clientSecret !== "") {
                    $PayPalRestApi = new \Utilities\PayPal\PayPalRestApi($clientId, $clientSecret, "sandbox");
                    $result = $PayPalRestApi->captureOrder($session_token);

                    if ($pedido !== null) {
                        $estadoPago = (isset($result->status) && $result->status === "COMPLETED") ? "Pagado" : "Rechazado";
                        DaoPedidos::marcarPago($session_token, $estadoPago);
                    }

                    $dataview["orderjson"] = json_encode($result, JSON_PRETTY_PRINT);
                    $dataview["order_id"] = $session_token;
                    $dataview["total"] = $pedido["total"] ?? 0;
                    $dataview["items"] = $pedido["items"] ?? [];
                    $dataview["payment_method"] = $pedido["metodo_pago"] ?? "PayPal Sandbox";
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
}
