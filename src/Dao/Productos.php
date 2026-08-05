<?php

namespace Dao;

class Productos extends Table
{

    public static function getAll()
    {
        $sql = "SELECT
                    p.id_producto AS prdcod,
                    p.nombre AS prddsc,
                    p.precio AS prdcosto,
                    p.imagen AS prdimg,
                    CASE WHEN c.estado = 'Inactivo' THEN 'No disponible' ELSE p.estado END AS prdest,
                    c.nombre AS prdcategoria,
                    p.descripcion,
                    p.stock
                FROM productos p
                INNER JOIN categorias c
                    ON p.id_categoria = c.id_categoria
                ORDER BY p.nombre;";

        return self::obtenerRegistros($sql, []);
    }

    public static function getById($prdcod)
    {
        $sql = "SELECT
                    p.id_producto AS prdcod,
                    p.nombre AS prddsc,
                    p.precio AS prdcosto,
                    p.imagen AS prdimg,
                    CASE WHEN c.estado = 'Inactivo' THEN 'No disponible' ELSE p.estado END AS prdest,
                    p.id_categoria AS prdcategoria,
                    p.descripcion,
                    p.stock
                FROM productos p
                INNER JOIN categorias c
                    ON p.id_categoria = c.id_categoria
                WHERE p.id_producto = :prdcod;";

        return self::obtenerUnRegistro(
            $sql,
            [
                "prdcod"=>$prdcod
            ]
        );
    }

    public static function getProducts(
        $partialName = "",
        $status = "",
        $orderBy = "",
        $orderDescending = false,
        $page = 0,
        $itemsPerPage = 10
    ) {
        $where = " WHERE 1=1";
        $params = [];

        // Mostrar solo productos de categorías activas en el catálogo.
        $where .= " AND c.estado = 'Activo'";

        if (!empty($partialName)) {
            $where .= " AND (p.nombre LIKE :partialName OR p.descripcion LIKE :partialName)";
            $params["partialName"] = "%" . $partialName . "%";
        }

        if (!empty($status)) {
            $where .= " AND p.estado = :status";
            $params["status"] = $status;
        }

        $orderBySql = "ORDER BY p.nombre ASC";
        switch ($orderBy) {
            case "productId":
                $orderBySql = "ORDER BY MIN(p.id_producto)";
                break;
            case "productName":
                $orderBySql = "ORDER BY p.nombre";
                break;
            case "productPrice":
                $orderBySql = "ORDER BY MIN(p.precio)";
                break;
            default:
                $orderBySql = "ORDER BY p.nombre";
                break;
        }

        if ($orderDescending) {
            $orderBySql .= " DESC";
        } else {
            $orderBySql .= " ASC";
        }

        $offset = max(0, intval($page));
        $limit = intval($itemsPerPage);

        $sql = "SELECT
                    MIN(p.id_producto) AS prdcod,
                    p.nombre AS prddsc,
                    MIN(p.precio) AS prdcosto,
                    MIN(p.imagen) AS prdimg,
                    MIN(CASE WHEN c.estado = 'Inactivo' THEN 'No disponible' ELSE p.estado END) AS prdest,
                    MIN(c.nombre) AS prdcategoria,
                    MIN(p.descripcion) AS descripcion,
                    MIN(p.stock) AS stock
                FROM productos p
                INNER JOIN categorias c
                    ON p.id_categoria = c.id_categoria"
                . $where . " GROUP BY p.nombre " . $orderBySql;

        if ($limit > 0) {
            $sql .= " LIMIT :offset, :limit";
            $params["offset"] = max(0, $offset * max(1, $limit));
            $params["limit"] = $limit;
        }

        $products = self::obtenerRegistros($sql, $params);

        $countParams = $params;
        unset($countParams["offset"], $countParams["limit"]);

        $sqlCount = "SELECT COUNT(DISTINCT p.nombre) as total
                    FROM productos p
                    INNER JOIN categorias c
                        ON p.id_categoria = c.id_categoria"
                    . $where . ";";
        $countResult = self::obtenerUnRegistro($sqlCount, $countParams);
        $total = intval($countResult["total"] ?? 0);

        return [
            "products" => $products,
            "total" => $total
        ];
    }

    public static function insert(
        $prddsc,
        $prdcosto,
        $prdimg,
        $prdest,
        $prdcategoria,
        $descripcion,
        $stock
    ){

        $sql="INSERT INTO productos
            (
                id_categoria,
                nombre,
                descripcion,
                precio,
                stock,
                imagen,
                estado
            )
            VALUES
            (
                :id_categoria,
                :nombre,
                :descripcion,
                :precio,
                :stock,
                :imagen,
                :estado
            );";

        return self::executeNonQuery(
            $sql,
            [
                "id_categoria"=>$prdcategoria,
                "nombre"=>$prddsc,
                "descripcion"=>$descripcion,
                "precio"=>$prdcosto,
                "stock"=>$stock,
                "imagen"=>$prdimg,
                "estado"=>$prdest
            ]
        );
    }

    public static function update(
        $prdcod,
        $prddsc,
        $prdcosto,
        $prdimg,
        $prdest,
        $prdcategoria,
        $descripcion,
        $stock
    ){

        $sql="UPDATE productos
                SET
                    id_categoria=:id_categoria,
                    nombre=:nombre,
                    descripcion=:descripcion,
                    precio=:precio,
                    stock=:stock,
                    imagen=:imagen,
                    estado=:estado
              WHERE id_producto=:id;";

        return self::executeNonQuery(
            $sql,
            [
                "id"=>$prdcod,
                "id_categoria"=>$prdcategoria,
                "nombre"=>$prddsc,
                "descripcion"=>$descripcion,
                "precio"=>$prdcosto,
                "stock"=>$stock,
                "imagen"=>$prdimg,
                "estado"=>$prdest
            ]
        );
    }

    public static function updateStatusByCategoria($catcod, $estado)
    {
        $sql = "UPDATE productos
                SET estado = :estado
                WHERE id_categoria = :catcod;";

        return self::executeNonQuery(
            $sql,
            [
                "estado" => $estado,
                "catcod" => $catcod
            ]
        );
    }

    public static function delete($prdcod)
    {
        $sql="DELETE FROM productos
              WHERE id_producto=:id;";

        return self::executeNonQuery(
            $sql,
            [
                "id"=>$prdcod
            ]
        );
    }

    public static function countByCategoria($catcod)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM productos
                WHERE id_categoria = :catcod;";

        $result = self::obtenerUnRegistro(
            $sql,
            [
                "catcod" => $catcod
            ]
        );

        return intval($result["total"] ?? 0);
    }
}