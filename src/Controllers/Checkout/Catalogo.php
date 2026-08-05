<?php

namespace Controllers\Checkout;

use Controllers\PublicController;
use Dao\Productos;
use Utilities\Context;
use Utilities\Paging;
use Views\Renderer;

class Catalogo extends PublicController
{
    private $partialName = "";
    private $status = "";
    private $orderBy = "";
    private $orderDescending = false;
    private $pageNumber = 1;
    private $itemsPerPage = 20;
    private $viewData = [];
    private $productos = [];
    private $productosCount = 0;
    private $pages = 1;

    public function run(): void
    {
        $this->getParamsFromContext();
        $this->getParams();

        // Mostrar todos los productos disponibles sin límite de paginación.
        $this->pageNumber = 1;
        $this->itemsPerPage = 0;

        $tmpProducts = Productos::getProducts(
            $this->partialName,
            $this->status,
            $this->orderBy,
            $this->orderDescending,
            0,
            $this->itemsPerPage
        );

        $this->productos = $tmpProducts["products"];
        $this->productosCount = $tmpProducts["total"];
        $this->pages = 1;

        if ($this->pageNumber > $this->pages) {
            $this->pageNumber = $this->pages;
        }

        $this->setParamsToContext();
        $this->setParamsToDataView();

        Renderer::render("checkout/catalogo", $this->viewData);
    }

    private function getParams(): void
    {
        $this->partialName = isset($_GET["partialName"]) ? trim($_GET["partialName"]) : $this->partialName;

        if (isset($_GET["status"])) {
            $this->status = in_array($_GET["status"], ["Disponible", "No disponible", "EMP"]) ? $_GET["status"] : "";
        }
        if ($this->status === "EMP") {
            $this->status = "";
        }
        if (!in_array($this->status, ["", "Disponible", "No disponible"], true)) {
            $this->status = "";
        }

        if (isset($_GET["orderBy"])) {
            $this->orderBy = in_array($_GET["orderBy"], ["productId", "productName", "productPrice", "clear"], true) ? $_GET["orderBy"] : "";
        }
        if ($this->orderBy === "clear") {
            $this->orderBy = "";
        }
        if (!in_array($this->orderBy, ["", "productId", "productName", "productPrice"], true)) {
            $this->orderBy = "";
        }

        if (isset($_GET["orderDescending"])) {
            $this->orderDescending = boolval($_GET["orderDescending"]);
        }

        $this->pageNumber = isset($_GET["pageNum"]) ? max(1, intval($_GET["pageNum"])) : $this->pageNumber;
        if ($this->pageNumber < 1) {
            $this->pageNumber = 1;
        }

        $this->itemsPerPage = isset($_GET["itemsPerPage"]) ? max(1, intval($_GET["itemsPerPage"])) : $this->itemsPerPage;
        if ($this->itemsPerPage < 1) {
            $this->itemsPerPage = 10;
        }
    }

    private function getParamsFromContext(): void
    {
        $hasPageNum = isset($_GET["pageNum"]);
        $hasItemsPerPage = isset($_GET["itemsPerPage"]);

        $this->partialName = Context::getContextByKey("catalog_partialName") ?: $this->partialName;
        $this->status = Context::getContextByKey("catalog_status") ?: $this->status;
        $this->orderBy = Context::getContextByKey("catalog_orderBy") ?: $this->orderBy;
        $this->orderDescending = boolval(Context::getContextByKey("catalog_orderDescending"));
        $this->pageNumber = intval(Context::getContextByKey("catalog_page"));
        $this->itemsPerPage = intval(Context::getContextByKey("catalog_itemsPerPage"));

        if (!$hasPageNum) {
            $this->pageNumber = 1;
        }

        if (!$hasItemsPerPage && !$hasPageNum) {
            $this->itemsPerPage = 20;
        }

        if ($this->pageNumber < 1) {
            $this->pageNumber = 1;
        }
        if ($this->itemsPerPage < 1) {
            $this->itemsPerPage = 20;
        }
    }

    private function setParamsToContext(): void
    {
        Context::setContext("catalog_partialName", $this->partialName, true);
        Context::setContext("catalog_status", $this->status, true);
        Context::setContext("catalog_orderBy", $this->orderBy, true);
        Context::setContext("catalog_orderDescending", $this->orderDescending, true);
        Context::setContext("catalog_page", $this->pageNumber, true);
        Context::setContext("catalog_itemsPerPage", $this->itemsPerPage, true);
    }

    private function setParamsToDataView(): void
    {
        $this->viewData = [
            "titulo" => "Catálogo La Neverita",
            "productos" => $this->productos,
            "partialName" => $this->partialName,
            "status" => $this->status,
            "orderBy" => $this->orderBy,
            "orderDescending" => $this->orderDescending,
            "pageNum" => $this->pageNumber,
            "itemsPerPage" => $this->itemsPerPage,
            "productosCount" => $this->productosCount,
            "pages" => $this->pages,
            "showAllProducts" => true
        ];

        if ($this->orderBy !== "") {
            $orderByKey = "Order" . ucfirst($this->orderBy);
            $orderByKeyNoOrder = "OrderBy" . ucfirst($this->orderBy);
            $this->viewData[$orderByKeyNoOrder] = true;
            if ($this->orderDescending) {
                $orderByKey .= "Desc";
            }
            $this->viewData[$orderByKey] = true;
        }

        $statusKey = "status_" . ($this->status === "" ? "EMP" : str_replace(" ", "", $this->status));
        $this->viewData[$statusKey] = "selected";

        if ($this->itemsPerPage > 0) {
            $this->viewData["pagination"] = Paging::getPagination(
                $this->productosCount,
                $this->itemsPerPage,
                $this->pageNumber,
                "index.php?page=Checkout_Catalogo",
                "Checkout_Catalogo"
            );
        } else {
            $this->viewData["pagination"] = "";
        }
    }
}
