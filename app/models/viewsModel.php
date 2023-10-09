<?php
	
	namespace app\models;

	class viewsModel{

		/*---------- Modelo para obter as views da aplicação ----------*/
		protected function obtainViewsModel($view){

			$whiteList=["dashboard","userNew","userList","userUpdate","userSearch","userPhoto","logOut"];

			if(in_array($view, $whiteList)){
				if(is_file("./app/views/content/".$view."-view.php")){
					$content="./app/views/content/".$view."-view.php";
				}else{
					$content="404";
				}
			}elseif($view=="login" || $view=="index"){
				$content="login";
			}else{
				$content="404";
			}
			return $content;
		}

	}