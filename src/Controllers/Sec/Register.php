<?php

namespace Controllers\Sec;

use Controllers\PublicController;
use Utilities\Validators;

class Register extends PublicController
{
    private $txtNombre = "";
    private $txtApellido = "";
    private $txtEmail = "";
    private $txtTelefono = "";
    private $txtDireccion = "";
    private $txtPswd = "";
    private $txtPswd2 = "";

    private $errorNombre = "";
    private $errorApellido = "";
    private $errorEmail = "";
    private $errorTelefono = "";
    private $errorDireccion = "";
    private $errorPswd = "";
    private $errorPswd2 = "";

    private $hasErrors = false;

    public function run() : void
    {
        if ($this->isPostBack()) {

            $this->txtNombre = trim($_POST["txtNombre"]);
            $this->txtApellido = trim($_POST["txtApellido"]);
            $this->txtEmail = trim($_POST["txtEmail"]);
            $this->txtTelefono = trim($_POST["txtTelefono"]);
            $this->txtDireccion = trim($_POST["txtDireccion"]);
            $this->txtPswd = $_POST["txtPswd"];
            $this->txtPswd2 = $_POST["txtPswd2"];

            // Nombre
            if (Validators::IsEmpty($this->txtNombre)) {
                $this->errorNombre = "Ingrese su nombre.";
                $this->hasErrors = true;
            }

            // Apellido
            if (Validators::IsEmpty($this->txtApellido)) {
                $this->errorApellido = "Ingrese su apellido.";
                $this->hasErrors = true;
            }

            // Correo
            if (!Validators::IsValidEmail($this->txtEmail)) {
                $this->errorEmail = "Correo electrónico inválido.";
                $this->hasErrors = true;
            }

            // Teléfono
            if (Validators::IsEmpty($this->txtTelefono)) {
                $this->errorTelefono = "Ingrese su teléfono.";
                $this->hasErrors = true;
            }

            // Dirección
            if (Validators::IsEmpty($this->txtDireccion)) {
                $this->errorDireccion = "Ingrese su dirección.";
                $this->hasErrors = true;
            }

            // Contraseña
            if (!Validators::IsValidPassword($this->txtPswd)) {
                $this->errorPswd = "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.";
                $this->hasErrors = true;
            }

            // Confirmación
            if ($this->txtPswd != $this->txtPswd2) {
                $this->errorPswd2 = "Las contraseñas no coinciden.";
                $this->hasErrors = true;
            }

            if (!$this->hasErrors) {

                if (\Dao\Security\Security::newUsuario(
                    $this->txtNombre,
                    $this->txtApellido,
                    $this->txtEmail,
                    $this->txtTelefono,
                    $this->txtDireccion,
                    $this->txtPswd
                )) {

                    \Utilities\Site::redirectToWithMsg(
                        "index.php?page=sec_login",
                        "¡Usuario registrado correctamente!"
                    );
                }
            }
        }

        $viewData = get_object_vars($this);
        \Views\Renderer::render("security/sigin", $viewData);
    }
}