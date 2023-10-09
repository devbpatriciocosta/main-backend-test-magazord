<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\searchController;

	if(isset($_POST['modulo_buscador'])){

		$insPesquisar = new searchController();

		if($_POST['modulo_buscador']=="pesquisar"){
			echo $insPesquisar->iniciarPesquisaControlador();
		}

		if($_POST['modulo_buscador']=="deletar"){
			echo $insPesquisar->deletarPesquisaControlador();
		}
		
	} else {
		session_destroy();
		header("Location: ".APP_URL."login/");
	}