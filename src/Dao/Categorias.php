<?php

namespace Dao;

class Categorias extends Table
{
    public static function getAll()
    {
        return array(
            array(
                "catcod" => 1,
                "catdsc" => "Helados",
                "catest" => "ACT"
            ),
            array(
                "catcod" => 2,
                "catdsc" => "Gelatinas",
                "catest" => "ACT"
            ),
            array(
                "catcod" => 3,
                "catdsc" => "Granizados",
                "catest" => "ACT"
            ),
            array(
                "catcod" => 4,
                "catdsc" => "Frutas locas",
                "catest" => "ACT"
            )
        );
    }

    public static function getById($catcod)
    {
        $items = self::getAll();
        foreach ($items as $item) {
            if ($item["catcod"] == $catcod) {
                return $item;
            }
        }
        return null;
    }

    public static function insert($catdsc, $catest)
    {
        return true;
    }

    public static function update($catcod, $catdsc, $catest)
    {
        return true;
    }

    public static function delete($catcod)
    {
        return true;
    }
}
