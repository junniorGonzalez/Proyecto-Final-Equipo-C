<?php

namespace Controllers\Admin;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Categorias as DaoCategorias;
use Utilities\Site;

class CategoriaForm extends PublicController
{
    private $mode = "INS";
    private $modeDescriptions = array(
        "INS" => "Agregar Nueva Categoría",
        "UPD" => "Editar Categoría",
        "DEL" => "Eliminar Categoría"
    );

    public function run(): void
    {
        $viewData = array(
            "catcod" => 0,
            "catdsc" => "",
            "catest" => "ACT",
            "readonly" => ""
        );

        if (isset($_GET["mode"])) {
            $this->mode = $_GET["mode"];
        }

        if (isset($_GET["catcod"])) {
            $viewData["catcod"] = intval($_GET["catcod"]);
            $tmpData = DaoCategorias::getById($viewData["catcod"]);
            if ($tmpData) {
                $viewData = array_merge($viewData, $tmpData);
            }
        }

        if ($this->isPostBack()) {
            $this->handlePost($viewData);
        }

        $viewData["mode"] = $this->mode;
        $viewData["mode_desc"] = $this->modeDescriptions[$this->mode] ?? "Gestionar Categoría";

        if ($this->mode === "DEL") {
            $viewData["readonly"] = "disabled";
        } else {
            $viewData["readonly"] = "";
        }

        Renderer::render("admin/categoria_form", $viewData);
    }

    private function handlePost(&$viewData)
    {
        $mode = $_POST["mode"] ?? "INS";
        $catcod = intval($_POST["catcod"] ?? 0);
        // Lee catdsc o catnom por si la vista envía cualquiera de los dos
        $catdsc = $_POST["catdsc"] ?? $_POST["catnom"] ?? "";
        $catest = $_POST["catest"] ?? "ACT";

        switch ($mode) {
            case "INS":
                DaoCategorias::insert($catdsc, $catest);
                break;
            case "UPD":
                DaoCategorias::update($catcod, $catdsc, $catest);
                break;
            case "DEL":
                DaoCategorias::delete($catcod);
                break;
        }

        Site::redirectTo("index.php?page=Admin_Categorias");
    }
}
