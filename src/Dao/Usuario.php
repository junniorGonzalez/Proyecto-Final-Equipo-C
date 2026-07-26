<?php

namespace Dao;

class Usuario extends Table
{
    /**
     * Buscar un usuario por correo
     */
    public static function buscarPorCorreo($correo)
    {
        $sql = "SELECT *
                FROM usuarios
                WHERE correo = :correo
                LIMIT 1;";

        return self::obtenerUnRegistro(
            $sql,
            array(
                "correo" => $correo
            )
        );
    }

    /**
     * Buscar usuario por ID
     */
    public static function buscarPorId($id)
    {
        $sql = "SELECT *
                FROM usuarios
                WHERE id_usuario = :id
                LIMIT 1;";

        return self::obtenerUnRegistro(
            $sql,
            array(
                "id" => $id
            )
        );
    }

    /**
     * Obtener todos los usuarios
     */
    public static function obtenerTodos()
    {
        $sql = "SELECT *
                FROM usuarios
                ORDER BY nombre ASC;";

        return self::obtenerRegistros($sql, array());
    }
}