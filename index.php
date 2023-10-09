<?php

    require_once "./config/app.php";
    require_once "./autoload.php";

    require_once "./app/views/inc/session_start.php";

    if(isset($_GET['views'])){
        $url=explode("/", $_GET['views']);
    }else{
        $url=["login"];
    }

?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <?php require_once "./app/views/inc/head.php"; ?>
    </head>
    <body>
        <?php
            use app\controllers\viewsController;
            use app\controllers\loginController;

            $insLogin           = new loginController();

            $viewsController    = new viewsController();
            $view               =$viewsController->obtainViewsControlador($url[0]);

            if($view=="login" || $view=="404"){
                require_once "./app/views/content/".$view."-view.php";
            }else{

                if((!isset($_SESSION['id']) || $_SESSION['id']=="") || (!isset($_SESSION['usuario']) || $_SESSION['usuario']=="")){
                    $insLogin->encerrarSessionControlador();
                    exit();
                }

                require_once "./app/views/inc/navbar.php";

                require_once $view;
            }

            require_once "./app/views/inc/script.php"; 
        ?>
    </body>
</html>