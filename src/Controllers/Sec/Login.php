<?php

namespace Controllers\Sec;

class Login extends \Controllers\PublicController
{
    private $txtEmail = "";
    private $txtPswd = "";
    private $errorEmail = "";
    private $errorPswd = "";
    private $generalError = "";
    private $hasError = false;

    public function run(): void
    {
        if ($this->isPostBack()) {

            $this->txtEmail = trim($_POST["txtEmail"]);
            $this->txtPswd = $_POST["txtPswd"];

            if (!\Utilities\Validators::IsValidEmail($this->txtEmail)) {
                $this->errorEmail = "El correo no tiene un formato válido.";
                $this->hasError = true;
            }

            if (\Utilities\Validators::IsEmpty($this->txtPswd)) {
                $this->errorPswd = "Debe ingresar una contraseña.";
                $this->hasError = true;
            }

            if (!$this->hasError) {

                $dbUser = \Dao\Security\Security::getUsuarioByEmail($this->txtEmail);

                if ($dbUser) {

                    if ($dbUser["estado"] != "Activo") {
                        $this->generalError = "La cuenta está inactiva.";
                        $this->hasError = true;
                    }

                    if (
                        !$this->hasError &&
                        !\Dao\Security\Security::verifyPassword(
                            $this->txtPswd,
                            $dbUser["password"]
                        )
                    ) {
                        $this->generalError = "Correo o contraseña incorrectos.";
                        $this->hasError = true;
                    }

                    if (!$this->hasError) {

                        \Utilities\Security::login(
                            $dbUser["id_usuario"],
                            $dbUser["nombre"],
                            $dbUser["correo"]
                        );

                        if (\Utilities\Context::getContextByKey("redirto") != "") {
                            \Utilities\Site::redirectTo(
                                \Utilities\Context::getContextByKey("redirto")
                            );
                        } else {
                            \Utilities\Site::redirectTo("index.php");
                        }
                    }

                } else {
                    $this->generalError = "Correo o contraseña incorrectos.";
                }
            }
        }

        $viewData = get_object_vars($this);

        \Views\Renderer::render("security/login", $viewData);
    }
}