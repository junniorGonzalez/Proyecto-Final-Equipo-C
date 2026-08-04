<?php

namespace Controllers\Admin;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Categorias as DaoCategorias;
use Utilities\Site;

class Categorias extends PublicController
{
    public function run(): void
    {
        // Eliminar directamente
        if ($this->isPostBack()) {

            $action = $_POST["action"] ?? "";

            if ($action == "DELETE") {

                $catcod = intval($_POST["catcod"] ?? 0);

                DaoCategorias::delete($catcod);

                Site::redirectTo("index.php?page=Admin_Categorias");
            }
        }

        $categorias = DaoCategorias::getAll();

        foreach ($categorias as &$categoria) {

            $estado = strtoupper(trim($categoria["catest"]));

            $categoria["catActivo"] = (
                $estado == "ACT" ||
                $estado == "ACTIVO" ||
                $estado == "ACTIVO "
            );
        }

        $viewData = [
            "categorias" => $categorias
        ];

        Renderer::render("admin/categorias", $viewData);
    }
}