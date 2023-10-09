<?php

	namespace app\controllers;
	use app\models\mainModel;

	class searchController extends mainModel{

		/*----------  Controlador das pesquisas  ----------*/
		public function modulosPesquisaControlador($modulo){

			$listaModulos		=['userSearch'];

			if(in_array($modulo, $listaModulos)){
				return false;
			}else{
				return true;
			}
		}


		/*----------  Controlador para iniciar as pesquisas  ----------*/
		public function iniciarPesquisaControlador(){

		    $url			=$this->cleanString($_POST['modulo_url']);
			$texto			=$this->cleanString($_POST['txt_buscador']);

			if($this->modulosPesquisaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ihhhh, a wild error appears! :(",
					"texto"=>"Não conseguir realizar a pesquisa no momento",
					"icon"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			if($texto==""){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ihhhh, a wild error appears! :(",
					"texto"=>"É necessário inserir um termo de pesquisa",
					"icon"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			if($this->verificarDados("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}",$texto)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ihhhh, a wild error appears! :(",
					"texto"=>"O termo pesquisado está errado",
					"icon"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			$_SESSION[$url]=$texto;

			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}


		/*----------  Controlador para apagar as pesquisas  ----------*/
		public function deletarPesquisaControlador(){

			$url=$this->cleanString($_POST['modulo_url']);

			if($this->modulosPesquisaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ihhhh, a wild error appears! :(",
					"texto"=>"Não podemos realizar a pesquisa no momento... ",
					"icon"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			unset($_SESSION[$url]);

			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}

	}