<?php

	namespace app\controllers;
	use app\models\viewsModel;

	class viewsController extends viewsModel{

		/*---------- Controlador para obter as views ----------*/
		public function obtainViewsControlador($view){
			if($view!=""){
				$response=$this->obtainViewsModel($view);
			}else{
				$response="login";
			}
			return $response;
		}
	}