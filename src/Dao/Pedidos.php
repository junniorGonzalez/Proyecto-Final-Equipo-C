<?php

namespace Dao;

class Pedidos extends Table
{
    // Estados válidos para el envío del pedido (deben coincidir con el ENUM de la tabla `pedidos`).
    public static $ESTADOS = ["Pendiente", "Preparando", "En camino", "Entregado", "Cancelado"];

    /**
     * Crea un pedido junto con su detalle y su registro de pago inicial.
     * Devuelve el id_pedido generado, o false si algo falló (se hace rollback).
     */
    public static function crear($idUsuario, $direccionEntrega, $total, array $items, $metodoPago, $referenciaPago)
    {
        $conn = self::getConn();

        try {
            self::beginTransaction();

            self::executeNonQuery(
                "INSERT INTO pedidos (id_usuario, direccion_entrega, total, estado)
                 VALUES (:id_usuario, :direccion_entrega, :total, 'Pendiente');",
                [
                    "id_usuario" => $idUsuario,
                    "direccion_entrega" => $direccionEntrega,
                    "total" => $total
                ],
                $conn
            );

            $idPedido = intval(self::lastInsertId());

            foreach ($items as $item) {
                self::executeNonQuery(
                    "INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio, subtotal)
                     VALUES (:id_pedido, :id_producto, :cantidad, :precio, :subtotal);",
                    [
                        "id_pedido" => $idPedido,
                        "id_producto" => $item["id_producto"],
                        "cantidad" => $item["cantidad"],
                        "precio" => $item["precio"],
                        "subtotal" => $item["subtotal"]
                    ],
                    $conn
                );
            }

            self::executeNonQuery(
                "INSERT INTO pagos (id_pedido, metodo_pago, referencia, monto, estado)
                 VALUES (:id_pedido, :metodo_pago, :referencia, :monto, 'Pendiente');",
                [
                    "id_pedido" => $idPedido,
                    "metodo_pago" => $metodoPago,
                    "referencia" => $referenciaPago,
                    "monto" => $total
                ],
                $conn
            );

            self::commit();

            return $idPedido;
        } catch (\Exception $ex) {
            self::rollBack();
            throw $ex;
        }
    }

    /**
     * Marca el pago de un pedido (buscado por la referencia de PayPal / demo) como pagado o rechazado.
     */
    public static function marcarPago($referencia, $estadoPago)
    {
        return self::executeNonQuery(
            "UPDATE pagos SET estado = :estado WHERE referencia = :referencia;",
            [
                "estado" => $estadoPago,
                "referencia" => $referencia
            ]
        );
    }

    public static function actualizarEstadoEnvio($idPedido, $estado)
    {
        if (!in_array($estado, self::$ESTADOS, true)) {
            return false;
        }

        return self::executeNonQuery(
            "UPDATE pedidos SET estado = :estado WHERE id_pedido = :id_pedido;",
            [
                "estado" => $estado,
                "id_pedido" => $idPedido
            ]
        );
    }

    /**
     * Pedido + pago, localizado por la referencia de pago (usado por la pantalla de confirmación).
     */
    public static function getByReferencia($referencia)
    {
        $sql = "SELECT
                    p.id_pedido,
                    p.id_usuario,
                    p.fecha,
                    p.direccion_entrega,
                    p.total,
                    p.estado,
                    pg.metodo_pago,
                    pg.referencia,
                    pg.estado AS estado_pago
                FROM pedidos p
                INNER JOIN pagos pg ON pg.id_pedido = p.id_pedido
                WHERE pg.referencia = :referencia
                LIMIT 1;";

        $pedido = self::obtenerUnRegistro($sql, ["referencia" => $referencia]);

        if ($pedido) {
            $pedido["items"] = self::getDetalle($pedido["id_pedido"]);
        }

        return $pedido ?: null;
    }

    /**
     * Todos los pedidos de un cliente (para su historial de compras).
     */
    public static function getByUsuario($idUsuario)
    {
        $sql = "SELECT
                    p.id_pedido,
                    p.fecha,
                    p.direccion_entrega,
                    p.total,
                    p.estado,
                    pg.metodo_pago,
                    pg.referencia,
                    pg.estado AS estado_pago
                FROM pedidos p
                LEFT JOIN pagos pg ON pg.id_pedido = p.id_pedido
                WHERE p.id_usuario = :id_usuario
                ORDER BY p.id_pedido DESC;";

        $pedidos = self::obtenerRegistros($sql, ["id_usuario" => $idUsuario]);

        foreach ($pedidos as &$pedido) {
            $pedido["items"] = self::getDetalle($pedido["id_pedido"]);
        }
        unset($pedido);

        return $pedidos;
    }

    /**
     * Todos los pedidos de todos los clientes (para el panel de administración).
     */
    public static function getAll()
    {
        $sql = "SELECT
                    p.id_pedido,
                    p.fecha,
                    p.direccion_entrega,
                    p.total,
                    p.estado,
                    u.nombre AS cliente_nombre,
                    u.apellido AS cliente_apellido,
                    u.correo AS cliente_correo,
                    u.telefono AS cliente_telefono,
                    pg.metodo_pago,
                    pg.referencia,
                    pg.estado AS estado_pago
                FROM pedidos p
                INNER JOIN usuarios u ON u.id_usuario = p.id_usuario
                LEFT JOIN pagos pg ON pg.id_pedido = p.id_pedido
                ORDER BY p.id_pedido DESC;";

        return self::obtenerRegistros($sql, []);
    }

    public static function getDetalle($idPedido)
    {
        $sql = "SELECT
                    d.id_producto,
                    pr.nombre,
                    d.cantidad,
                    d.precio,
                    d.subtotal
                FROM detalle_pedido d
                INNER JOIN productos pr ON pr.id_producto = d.id_producto
                WHERE d.id_pedido = :id_pedido;";

        return self::obtenerRegistros($sql, ["id_pedido" => $idPedido]);
    }
}
