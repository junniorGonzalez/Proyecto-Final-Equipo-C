<?php
namespace Dao\Security;

if (version_compare(phpversion(), '7.4.0', '<')) {
        define('PASSWORD_ALGORITHM', 1);  //BCRYPT
} else {
    define('PASSWORD_ALGORITHM', '2y');  //BCRYPT
}
/*
usercod     bigint(10) AI PK
useremail   varchar(80)
username    varchar(80)
userpswd    varchar(128)
userfching  datetime
userpswdest char(3)
userpswdexp datetime
userest     char(3)
useractcod  varchar(128)
userpswdchg varchar(128)
usertipo    char(3)

 */

use Exception;

class Security extends \Dao\Table
{
    static public function getUsuarios($filter = "", $page = -1, $items = 0)
    {
        $sqlstr = "";
        if ($filter == "" && $page == -1 && $items == 0) {
            $sqlstr = "SELECT * FROM usuario;";
        } else {
            //TODO: Terminar consultas FACET
            if ($page = -1 and $items = 0) {
                $sqlstr = sprintf("SELECT * FROM usuarios %s;", $filter);
            } else {
                $offset = ($page -1 * $items);
                $sqlstr = sprintf(
                    "SELECT * FROM usuarios %s limit %d, %d;",
                    $filter,
                    $offset,
                    $items
                );
            }
        }
        return self::obtenerRegistros($sqlstr, array());
    }

   static public function newUsuario(
    $nombre,
    $apellido,
    $correo,
    $telefono,
    $direccion,
    $password)
    {
        if (!\Utilities\Validators::IsValidEmail($correo)) {
            throw new Exception("Correo inválido");
        }

        if (!\Utilities\Validators::IsValidPassword($password)) {
            throw new Exception("Contraseña inválida");
        }

        if (self::getUsuarioByEmail($correo)) {
            throw new Exception("El correo ya está registrado.");
        }

        $sql = "INSERT INTO usuarios
                (
                    id_rol,
                    nombre,
                    apellido,
                    correo,
                    password,
                    telefono,
                    direccion,
                    estado
                )
                VALUES
                (
                    :id_rol,
                    :nombre,
                    :apellido,
                    :correo,
                    :password,
                    :telefono,
                    :direccion,
                    :estado
                );";

        return self::executeNonQuery(
            $sql,
            array(
                "id_rol" => 2,
                "nombre" => $nombre,
                "apellido" => $apellido,
                "correo" => $correo,
                "password" => password_hash($password, PASSWORD_BCRYPT),
                "telefono" => $telefono,
                "direccion" => $direccion,
                "estado" => "Activo"
            )
        );
    }

    static public function getUsuarioByEmail($correo)
    {
        $sql = "SELECT *
                FROM usuarios
                WHERE correo = :correo
                LIMIT 1;";

        return self::obtenerUnRegistro(
            $sql,
            array(
                "correo" => $correo
            )
        );
    }

    static private function _saltPassword($password)
    {
        return hash_hmac(
            "sha256",
            $password,
            \Utilities\Context::getContextByKey("PWD_HASH")
        );
    }

    static private function _hashPassword($password)
    {
        return password_hash(self::_saltPassword($password), PASSWORD_ALGORITHM);
    }

   static public function verifyPassword($raw_password, $hash_password)
    {
        return password_verify($raw_password, $hash_password);
    }


    static private function _usuarioStruct()
    {
        return array(
            "usercod"      => "",
            "useremail"    => "",
            "username"     => "",
            "userpswd"     => "",
            "userfching"   => "",
            "userpswdest"  => "",
            "userpswdexp"  => "",
            "userest"      => "",
            "useractcod"   => "",
            "userpswdchg"  => "",
            "usertipo"     => "",
        );
    }

    static public function getFeature($fncod)
    {
        $sqlstr = "SELECT * from funciones where fncod=:fncod;";
        $featuresList = self::obtenerRegistros($sqlstr, array("fncod"=>$fncod));
        return count($featuresList) > 0;
    }

    static public function addNewFeature($fncod, $fndsc, $fnest, $fntyp )
    {
        $sqlins = "INSERT INTO `funciones` (`fncod`, `fndsc`, `fnest`, `fntyp`)
            VALUES (:fncod , :fndsc , :fnest , :fntyp );";

        return self::executeNonQuery(
            $sqlins,
            array(
                "fncod" => $fncod,
                "fndsc" => $fndsc,
                "fnest" => $fnest,
                "fntyp" => $fntyp
            )
        );
    }

    static public function getFeatureByUsuario($userCod, $fncod)
    {
        $sqlstr = "select * from
        funciones_roles a inner join roles_usuarios b on a.rolescod = b.rolescod
        where a.fnrolest = 'ACT' and b.roleuserest='ACT' and b.usercod=:usercod
        and a.fncod=:fncod limit 1;";
        $resultados = self::obtenerRegistros(
            $sqlstr,
            array(
                "usercod"=> $userCod,
                "fncod" => $fncod
            )
        );
        return count($resultados) > 0;
    }

    static public function getRol($rolescod)
    {
        $sqlstr = "SELECT * from roles where rolescod=:rolescod;";
        $featuresList = self::obtenerRegistros($sqlstr, array("rolescod" => $rolescod));
        return count($featuresList) > 0;
    }

    static public function addNewRol($rolescod, $rolesdsc, $rolesest)
    {
        $sqlins = "INSERT INTO `roles` (`rolescod`, `rolesdsc`, `rolesest`)
        VALUES (:rolescod, :rolesdsc, :rolesest);";

        return self::executeNonQuery(
            $sqlins,
            array(
                "rolescod" => $rolescod,
                "rolesdsc" => $rolesdsc,
                "rolesest" => $rolesest
            )
        );
    }

    static public function isUsuarioInRol($userCod, $rolescod)
    {
        $sqlstr = "select * from roles a inner join
        roles_usuarios b on a.rolescod = b.rolescod where a.rolesest = 'ACT'
        and b.usercod=:usercod and a.rolescod=:rolescod limit 1;";
        $resultados = self::obtenerRegistros(
            $sqlstr,
            array(
                "usercod" => $userCod,
                "rolescod" => $rolescod
            )
        );
        return count($resultados) > 0;
    }

    static public function getRolesByUsuario($userCod)
    {
        $sqlstr = "select * from roles a inner join
        roles_usuarios b on a.rolescod = b.rolescod where a.rolesest = 'ACT'
        and b.usercod=:usercod;";
        $resultados = self::obtenerRegistros(
            $sqlstr,
            array(
                "usercod" => $userCod
            )
        );
        return $resultados;
    }

    static public function removeRolFromUser($userCod, $rolescod)
    {
        $sqldel = "UPDATE roles_usuarios set roleuserest='INA' 
        where rolescod=:rolescod and usercod=:usercod;";
        return self::executeNonQuery(
            $sqldel,
            array("rolescod"=>$rolescod, "usercod"=>$userCod)
        );
    }

    static public function removeFeatureFromRol($fncod, $rolescod)
    {
        $sqldel = "UPDATE funciones_roles set roleuserest='INA'
        where fncod=:fncod and rolescod=:rolescod;";
        return self::executeNonQuery(
            $sqldel,
            array("fncod" => $fncod, "rolescod" => $rolescod)
        );
    }
    static public function getUnAssignedFeatures($rolescod)
    {
        
    }
    static public function getUnAssignedRoles($userCod)
    {

    }
    private function __construct()
    {
    }
    private function __clone()
    {
    }
}


?>
