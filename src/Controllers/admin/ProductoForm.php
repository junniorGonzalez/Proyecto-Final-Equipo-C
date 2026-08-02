<?php

namespace Controllers\Admin;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Productos as DaoProductos;

class ProductoForm extends PublicController
{
    private $mode = "INS";
    private $modeDescriptions = array(
        "INS" => "Agregar Nuevo Producto",
        "UPD" => "Editar Producto",
        "DEL" => "Eliminar Producto"
    );

    public function run(): void
    {
        $viewData = array(
            "prdcod" => 0,
            "prddsc" => "",
            "prdcosto" => 0,
            "prdimg" => "",
            "prdest" => "Disponible",
            "prdcategoria" => "",
            "descripcion" => "",
            "stock" => 0,
            "readonly" => ""
        );

        if (isset($_GET["mode"])) {
            $this->mode = $_GET["mode"];
        }

        if (isset($_GET["prdcod"])) {
            $viewData["prdcod"] = intval($_GET["prdcod"]);
            $tmpData = DaoProductos::getById($viewData["prdcod"]);
            if ($tmpData) {
                $viewData = array_merge($viewData, $tmpData);
            }
        }

        if ($this->isPostBack()) {
            $this->handlePost($viewData);
        }

        $viewData["mode"] = $this->mode;
        $viewData["mode_desc"] = $this->modeDescriptions[$this->mode] ?? "Gestionar Producto";

        // Solo si es eliminación (DEL) deshabilitamos los campos
        if ($this->mode === "DEL") {
            $viewData["readonly"] = "disabled";
        } else {
            $viewData["readonly"] = "";
        }

        Renderer::render("admin/producto_form", $viewData);
    }

    private function handlePost(&$viewData)
    {
        $mode = $_POST["mode"] ?? "INS";
        $prdcod = intval($_POST["prdcod"] ?? 0);
        $prddsc = $_POST["prddsc"] ?? "";
        $prdcosto = floatval($_POST["prdcosto"] ?? 0);
        $prdest = $_POST["prdest"] ?? "Disponible";
        $prdcategoria = $_POST["prdcategoria"] ?? "";
        $descripcion = $_POST["descripcion"] ?? "";
        $stock = intval($_POST["stock"] ?? 0);
        $imgPath = $_POST["prdimg"] ?? "";

        if (isset($_FILES["prdimg_file"]) && $_FILES["prdimg_file"]["error"] == UPLOAD_ERR_OK) {
            $fileName = time() . "_" . basename($_FILES["prdimg_file"]["name"]);
            $targetPath = "public/imgs/" . $fileName;
            if (move_uploaded_file($_FILES["prdimg_file"]["tmp_name"], $targetPath)) {
                $imgPath = $targetPath;
            }
        }

        switch ($mode) {
            case "INS":
                DaoProductos::insert($prddsc, $prdcosto, $imgPath, $prdest, $prdcategoria, $descripcion, $stock);
                break;
            case "UPD":
                DaoProductos::update($prdcod, $prddsc, $prdcosto, $imgPath, $prdest, $prdcategoria, $descripcion, $stock);
                break;
            case "DEL":
                DaoProductos::delete($prdcod);
                break;
        }

        \Utilities\Site::redirectToWithMsg(
            "index.php?page=Admin_Productos",
            "Operación realizada exitosamente."
        );
    }
}
