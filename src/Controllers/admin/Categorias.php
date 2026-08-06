<?php

namespace Controllers\Admin;

use Controllers\AdminController;
use Views\Renderer;
use Dao\Categorias as DaoCategorias;
use Dao\Productos as DaoProductos;
use Utilities\Site;

class Categorias extends AdminController
{
    public function run(): void
    {
        // Eliminar directamente
        if ($this->isPostBack()) {

            $action = $_POST["action"] ?? "";

            if ($action == "DELETE") {

                $catcod = intval($_POST["catcod"] ?? 0);

                $cantidadProductos = DaoProductos::countByCategoria($catcod);

                if ($cantidadProductos > 0) {
                    Site::redirectToWithMsg("index.php?page=Admin_Categorias", "No puede eliminar la categoría porque tiene productos asociados.");
                }

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