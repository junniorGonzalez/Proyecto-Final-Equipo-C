<?php

namespace Dao;

class Productos extends Table
{
    public static function getAll()
    {
        return array(
            array(
                "prdcod" => 1,
                "prddsc" => "Chocobanano",
                "prdcosto" => 15,
                "prdimg" => "public/imgs/Chocobananos.jpeg",
                "prdest" => "Disponible",
                "prdcategoria" => "Helados",
                "descripcion" => "Bananos cubiertos de chocolate con chispitas de colores y leche condensada",
                "stock" => 50
            ),
            array(
                "prdcod" => 2,
                "prddsc" => "Flan",
                "prdcosto" => 25,
                "prdimg" => "public/imgs/Flan.jpeg",
                "prdest" => "Disponible",
                "prdcategoria" => "Gelatinas",
                "descripcion" => "Producto creado a base de leche, con sabor a vainilla, con caramelo",
                "stock" => 40
            ),
            array(
                "prdcod" => 3,
                "prddsc" => "Gelaflan",
                "prdcosto" => 25,
                "prdimg" => "public/imgs/Gelaflan.jpeg",
                "prdest" => "Disponible",
                "prdcategoria" => "Gelatinas",
                "descripcion" => "Postre combinado entre gelatina y flan",
                "stock" => 60
            ),
            array(
                "prdcod" => 4,
                "prddsc" => "Gelatina de chicle",
                "prdcosto" => 20,
                "prdimg" => "public/imgs/Gelatinachicle.jpeg",
                "prdest" => "Disponible",
                "prdcategoria" => "Gelatinas",
                "descripcion" => "Postre ligero a base de agua con sabor a chicle",
                "stock" => 30
            ),
            array(
                "prdcod" => 5,
                "prddsc" => "Gelatina con frutas",
                "prdcosto" => 45,
                "prdimg" => "public/imgs/Gelatinaconfrutas.jpeg",
                "prdest" => "Disponible",
                "prdcategoria" => "Gelatinas",
                "descripcion" => "Postre creado a base de gelatina y frutas con topic de leche condensada y granola",
                "stock" => 60
            ),
            array(
                "prdcod" => 6,
                "prddsc" => "Gelatina de Fresa",
                "prdcosto" => 20,
                "prdimg" => "public/imgs/Gelatinafresa.jpeg",
                "prdest" => "Disponible",
                "prdcategoria" => "Gelatinas",
                "descripcion" => "Postre ligero a base de agua con sabor a Fresa",
                "stock" => 60
            ),
            array(
                "prdcod" => 7,
                "prddsc" => "Gelatina de Mosaico",
                "prdcosto" => 45,
                "prdimg" => "public/imgs/GelatinaMosaico.jpeg",
                "prdest" => "Disponible",
                "prdcategoria" => "Gelatinas",
                "descripcion" => "Postre combinado entre gelatina de sabor fresa y gelatina 3 leches, con fresa natural glaseada.",
                "stock" => 60
            ),
            array(
                "prdcod" => 8,
                "prddsc" => "Gelatina de Naranja",
                "prdcosto" => 20,
                "prdimg" => "public/imgs/Gelatinanaranja.jpeg",
                "prdest" => "Disponible",
                "prdcategoria" => "Gelatinas",
                "descripcion" => "Postre ligero a base de agua con sabor a Naranja",
                "stock" => 60
            ),
            array(
                "prdcod" => 9,
                "prddsc" => "Gelatina de Piña",
                "prdcosto" => 20,
                "prdimg" => "public/imgs/GelatinaPina.jpeg",
                "prdest" => "Disponible",
                "prdcategoria" => "Gelatinas",
                "descripcion" => "Postre ligero a base de agua con sabor a Piña",
                "stock" => 60
            ),
            array(
                "prdcod" => 10,
                "prddsc" => "Gelatina de Uva",
                "prdcosto" => 20,
                "prdimg" => "public/imgs/GelatinaUva.jpeg",
                "prdest" => "Disponible",
                "prdcategoria" => "Gelatinas",
                "descripcion" => "Postre ligero a base de agua con sabor a Uva",
                "stock" => 60
            ),
            array(
                "prdcod" => 11,
                "prddsc" => "Granizado de cafe",
                "prdcosto" => 85,
                "prdimg" => "public/imgs/Granizadodecafe.jpeg",
                "prdest" => "Disponible",
                "prdcategoria" => "Granizados",
                "descripcion" => "Elaborado a base cafe con leche y chocolate",
                "stock" => 60
            ),
            array(
                "prdcod" => 12,
                "prddsc" => "Granizado de Fresa",
                "prdcosto" => 80,
                "prdimg" => "public/imgs/Granizadodefresa.jpeg",
                "prdest" => "Disponible",
                "prdcategoria" => "Granizados",
                "descripcion" => "Elaborada con fresas natutales, con un toque de hershey de fresa.",
                "stock" => 60
            ),
            array(
                "prdcod" => 13,
                "prddsc" => "Granizado de Maracuya",
                "prdcosto" => 80,
                "prdimg" => "public/imgs/Granizadodemaracuya.jpeg",
                "prdest" => "Disponible",
                "prdcategoria" => "Granizados",
                "descripcion" => "Elaborado con pulpa natural de mayacuya y un toque de leche condensada.",
                "stock" => 60
            ),
            array(
                "prdcod" => 14,
                "prddsc" => "Granizado de Nance",
                "prdcosto" => 80,
                "prdimg" => "public/imgs/Granizadodenance.jpeg",
                "prdest" => "Disponible",
                "prdcategoria" => "Granizados",
                "descripcion" => "Elaborado con pulpa natural de nance.y un toque de leche condensada.",
                "stock" => 60
            ),
            array(
                "prdcod" => 15,
                "prddsc" => "Mangonada con Gomitas",
                "prdcosto" => 110,
                "prdimg" => "public/imgs/Mangonadacongomitas.jpeg",
                "prdest" => "Disponible",
                "prdcategoria" => "Granizados",
                "descripcion" => "Elaborada con mango natutal, preparada con tajin y chamoy con gomitas acidas y picantes.",
                "stock" => 60
            ),
            array(
                "prdcod" => 16,
                "prddsc" => "Piña loca",
                "prdcosto" => 160,
                "prdimg" => "public/imgs/Pinaloca.jpeg",
                "prdest" => "Disponible",
                "prdcategoria" => "Frutas locas",
                "descripcion" => "Piña fresca rellena de trozos de piña y sandía, cubierta con tajín, chamoy, gomitas y banderilla de tamarindo.",
                "stock" => 60
            ),
            array(
                "prdcod" => 17,
                "prddsc" => "Sandia loca",
                "prdcosto" => 200,
                "prdimg" => "public/imgs/Sandialoca.jpeg",
                "prdest" => "Disponible",
                "prdcategoria" => "Frutas locas",
                "descripcion" => "Sandía fresca servida con trozos de fruta, tajín, chamoy, gomitas ácidas y banderilla.",
                "stock" => 60
            ),
            array(
                "prdcod" => 18,
                "prddsc" => "Tutti Frutti",
                "prdcosto" => 50,
                "prdimg" => "public/imgs/TuttiFrutti.jpeg",
                "prdest" => "Disponible",
                "prdcategoria" => "Frutas locas",
                "descripcion" => "Mezcla de diversas frutas naturales con jugo de ponche de frutas",
                "stock" => 60
            ),
            array(
                "prdcod" => 19,
                "prddsc" => "Paleta de Frutas",
                "prdcosto" => 15,
                "prdimg" => "public/imgs/Paletadefrutas.jpeg",
                "prdest" => "Disponible",
                "prdcategoria" => "Helados",
                "descripcion" => "Paleta elaborada con variedades de frutas.",
                "stock" => 60
            ),
            array(
                "prdcod" => 20,
                "prddsc" => "Paleta de Coco",
                "prdcosto" => 12,
                "prdimg" => "public/imgs/Paletadecoco.png",
                "prdest" => "Disponible",
                "prdcategoria" => "Helados",
                "descripcion" => "Paleta de coco a base de leche",
                "stock" => 60
            )
        );
    }

    public static function getById($prdcod)
    {
        $items = self::getAll();
        foreach ($items as $item) {
            if ($item["prdcod"] == $prdcod) {
                return $item;
            }
        }
        return null;
    }

    public static function insert($prddsc, $prdcosto, $prdimg, $prdest, $prdcategoria, $descripcion, $stock)
    {
        return true;
    }

    public static function update($prdcod, $prddsc, $prdcosto, $prdimg, $prdest, $prdcategoria, $descripcion, $stock)
    {
        return true;
    }

    public static function delete($prdcod)
    {
        return true;
    }
}
