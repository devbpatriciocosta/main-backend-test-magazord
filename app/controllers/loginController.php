<?php

	namespace app\controllers;
	use app\models\mainModel;

	class loginController extends mainModel{

		/*----------  Controlador para dar início a uma sessão/fazer login  ----------*/
		public function iniciarSesionControlador(){

			$usuario		=$this->cleanString($_POST['login_usuario']);
		    $senha			=$this->cleanString($_POST['login_senha']);

		    # Verificação dos campos obrigatórios #
		    if($usuario=="" || $senha==""){
		        echo "<script>
			        Swal.fire({
					  icon: 'error',
					  title: 'Ihhhh, a wild error appears! :(',
					  text: 'Todos os campos precisam ser preenchidos!'
					});
				</script>";
		    }else{

			    # Verificação da veracidade dos dados #
			    if($this->verificarDados("[a-zA-Z0-9]{4,20}",$usuario)){
			        echo "<script>
				        Swal.fire({
						  icon: 'error',
						  title: 'Ihhhh, a wild error appears! :(',
						  text: 'O usuário inserido está errado'
						});
					</script>";
			    }else{

			    	 # Verificação da veracidade dos dados #
				    if($this->verificarDados("[a-zA-Z0-9$@.-]{7,100}",$senha)){
				        echo "<script>
					        Swal.fire({
							  icon: 'error',
							  title: 'Ihhhh, a wild error appears! :(',
							  text: 'A senha está em um formato errado'
							});
						</script>";
				    }else{

					    # Verificação de usuário/contato #
					    $check_usuario=$this->runQuery("SELECT * FROM usuario WHERE usuario_usuario='$usuario'");

					    if($check_usuario->rowCount()==1){

					    		$check_usuario			=$check_usuario->fetch();

					    	if($check_usuario['usuario_usuario']==$usuario && password_verify($senha,$check_usuario['usuario_cpf'])){

					    		$_SESSION['id']			=$check_usuario['usuario_id'];
					            $_SESSION['nombre']		=$check_usuario['usuario_nome'];
					            $_SESSION['apellido']	=$check_usuario['usuario_description'];
					            $_SESSION['usuario']	=$check_usuario['usuario_usuario'];
					            $_SESSION['foto']		=$check_usuario['usuario_foto'];


					            if(headers_sent()){
					                echo "<script> window.location.href='".APP_URL."dashboard/'; </script>";
					            }else{
					                header("Location: ".APP_URL."dashboard/");
					            }

					    	}else{
					    		echo "
								<script>
							        Swal.fire({
									  icon: 'error',
									  title: 'Ihhhh, a wild error appears! :(',
									  text: 'Usuário e senha incorretos'
									});
								</script>";
					    	}

					    }else{
					        echo "
							<script>
						        Swal.fire({
								  icon: 'error',
								  title: 'Ihhhh, a wild error appears! :(',
								  text: 'Usuário e senha incorretos!'
								});
							</script>";
					    }
				    }
			    }
		    }
		}


		/*----------  Controlador responsável por encerrar a sessão  ----------*/
		public function encerrarSessionControlador(){

			session_destroy();

		    if(headers_sent()){
                echo "<script> window.location.href='".APP_URL."login/'; </script>";
            }else{
                header("Location: ".APP_URL."login/");
            }
		}

	}