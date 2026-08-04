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
                    p.estado AS prdest,
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
                    p.estado AS prdest,
                    c.nombre AS prdcategoria,
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
}