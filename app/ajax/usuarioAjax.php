<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\userController;

	if(isset($_POST['modulo_usuario'])){

		$insUser = new userController();

		if($_POST['modulo_usuario']=="registrar"){
			echo $insUser->registrarContatoControlador();
		}

		if($_POST['modulo_usuario']=="deletar"){
			echo $insUser->deletarUsuarioControlador();
		}

		if($_POST['modulo_usuario']=="atualizar"){
			echo $insUser->updateUserController();
		}

		if($_POST['modulo_usuario']=="deletarFoto"){
			echo $insUser->deletarFotoUsuarioControlador();
		}

		if($_POST['modulo_usuario']=="atualizarFoto"){
			echo $insUser->atualizarFotoUsuarioControlador();
		}
		
	} else {
		session_destroy();
		header("Location: ".APP_URL."login/");
	}