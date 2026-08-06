<?php
namespace Controllers\Sec;
class Logout extends \Controllers\PublicController
{
    public function run():void
    {
        \Utilities\Security::logout();
        \Utilities\Nav::invalidateNavData();
        \Utilities\Site::redirectTo("index.php");
    }
}

?>
