<?php

namespace Dao;

class Categorias extends Table
{
    public static function getAll()
    {
        $sql = "SELECT
                    id_categoria AS catcod,
                    nombre AS catdsc,
                    estado AS catest
                FROM categorias
                ORDER BY id_categoria;";

        return self::obtenerRegistros($sql, []);
    }

    public static function getById($catcod)
    {
        $sql = "SELECT
                    id_categoria AS catcod,
                    nombre AS catdsc,
                    estado AS catest
                FROM categorias
                WHERE id_categoria = :catcod;";

        return self::obtenerUnRegistro(
            $sql,
            [
                "catcod" => $catcod
            ]
        );
    }

    public static function insert($catdsc, $catest)
    {
        $sql = "INSERT INTO categorias
                (nombre, estado)
                VALUES
                (:nombre, :estado);";

        return self::executeNonQuery(
            $sql,
            [
                "nombre" => $catdsc,
                "estado" => $catest
            ]
        );
    }

    public static function update($catcod, $catdsc, $catest)
    {
        $sql = "UPDATE categorias
                SET
                    nombre = :nombre,
                    estado = :estado
                WHERE id_categoria = :catcod;";

        return self::executeNonQuery(
            $sql,
            [
                "catcod" => $catcod,
                "nombre" => $catdsc,
                "estado" => $catest
            ]
        );
    }

    public static function delete($catcod)
    {
        $sql = "DELETE FROM categorias
                WHERE id_categoria = :catcod;";

        return self::executeNonQuery(
            $sql,
            [
                "catcod" => $catcod
            ]
        );
    }
}