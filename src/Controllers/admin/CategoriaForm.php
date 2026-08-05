<?php

namespace Controllers\Admin;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Categorias as DaoCategorias;
use Dao\Productos as DaoProductos;
use Utilities\Site;

class CategoriaForm extends PublicController
{
    public function run(): void
    {
        $mode = $_GET["mode"] ?? "INS";

        $viewData = [
            "mode" => $mode,
            "mode_desc" => "Nueva Categoría",
            "catcod" => 0,
            "catdsc" => "",
            "catest" => "Activo",
            "readonly" => "",
            "selACT" => "selected",
            "selINA" => ""
        ];

        switch ($mode) {
            case "UPD":
                $viewData["mode_desc"] = "Editar Categoría";
                break;

            case "INS":
                $viewData["mode_desc"] = "Agregar Categoría";
                break;
        }

        if (isset($_GET["catcod"])) {

            $categoria = DaoCategorias::getById((int)$_GET["catcod"]);

            if ($categoria) {

                $viewData["catcod"] = $categoria["catcod"];
                $viewData["catdsc"] = $categoria["catdsc"];
                $viewData["catest"] = $categoria["catest"];

                if (strtoupper($categoria["catest"]) == "INACTIVO") {
                    $viewData["selACT"] = "";
                    $viewData["selINA"] = "selected";
                }
            }
        }

        if ($this->isPostBack()) {

            $mode = $_POST["mode"];
            $catcod = intval($_POST["catcod"]);
            $catdsc = trim($_POST["catdsc"]);
            $catest = $_POST["catest"];

            if ($mode == "INS") {

                DaoCategorias::insert(
                    $catdsc,
                    $catest
                );

            } elseif ($mode == "UPD") {

                DaoCategorias::update(
                    $catcod,
                    $catdsc,
                    $catest
                );

                if (strtoupper(trim($catest)) === "INACTIVO") {
                    DaoProductos::updateStatusByCategoria($catcod, "No disponible");
                } elseif (strtoupper(trim($catest)) === "ACTIVO") {
                    DaoProductos::updateStatusByCategoria($catcod, "Disponible");
                }
            }

            Site::redirectTo("index.php?page=Admin_Categorias");
        }

        Renderer::render("admin/categoria_form", $viewData);
    }
}