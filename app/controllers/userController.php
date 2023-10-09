<?php

	namespace app\controllers;
	use app\models\mainModel;

	class userController extends mainModel{

		/*----------  Controlador de registro de contato  ----------*/
		public function registrarContatoControlador(){

			# Armazenando os dados#
		    $nome			=$this->cleanString($_POST['usuario_nome']);
		    $descricao		=$this->cleanString($_POST['usuario_description']);
		    $usuario		=$this->cleanString($_POST['usuario_usuario']);
		    $email			=$this->cleanString($_POST['usuario_email']);
		    $senha1			=$this->cleanString($_POST['usuario_cpf_1']);
		    $senha2			=$this->cleanString($_POST['usuario_cpf_2']);


		    # Verificação dos campos obrigatórios #
		    if($nome=="" || $descricao=="" || $usuario=="" || $senha1=="" || $senha2==""){
		    	$alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"Todos os campos são de preenchimento obrigatório",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Verificação da integridade dos dados #
		    if($this->verificarDados("[a-zA-ZáàâãéêíóôõúçñÑ ]{3,40}",$nome)){
		    	$alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"O nome do contato está em um formato não permitido",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDados("[a-zA-ZáàâãéêíóôõúçñÑ  ]{3,40}",$descricao)){
		    	$alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"A descrição não é permitida",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDados("[a-zA-Z0-9]{4,20}",$usuario)){
		    	$alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"O username está errado",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDados("[a-zA-Z0-9$@.-]{7,100}",$senha1) || $this->verificarDados("[a-zA-Z0-9$@.-]{7,100}",$senha2)){
		    	$alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"O CPF não coincide",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Verificando email #
		    if($email!=""){
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					$check_email=$this->runQuery("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
					if($check_email->rowCount()>0){
						$alerta=[
							"tipo"		=>	"simple",
							"titulo"	=>	"Ihhh, a wild error appears! :(",
							"texto"		=>	"O e-mail que você digitou já está cadastrado no sistema",
							"icon"		=>	"error"
						];
						return json_encode($alerta);
						exit();
					}
				} else {
					$alerta=[
						"tipo"		=>	"simple",
						"titulo"	=>	"Ihhh, a wild error appears! :(",
						"texto"		=>	"Este e-mail já está cadastrado",
						"icon"		=>	"error"
					];
					return json_encode($alerta);
					exit();
				}
            }

            # Verificando CPF que atua como senha #
            if($senha1!=$senha2){
				$alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"O CPF são diferentes. Precisam ser iguais.",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
				exit();
			} else {
				$senha=password_hash($senha1,PASSWORD_BCRYPT,["cost"=>10]);
            }

            # Verificando usuario #
		    $check_usuario=$this->runQuery("SELECT usuario_usuario FROM usuario WHERE usuario_usuario='$usuario'");
		    if($check_usuario->rowCount()>0){
		    	$alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"Este username já está em uso.",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Directorio de imagens #
    		$img_dir="../views/fotos/";

    		# Pra ter certeza que eu selecionei a imagem #
    		if($_FILES['usuario_foto']['name']!="" && $_FILES['usuario_foto']['size']>0){

    			# Criando um diretório para a imagem #
		        if(!file_exists($img_dir)){
		            if(!mkdir($img_dir,0777)){
		            	$alerta=[
							"tipo"		=>	"simple",
							"titulo"	=>	"Ihhh, a wild error appears! :(",
							"texto"		=>	"Erro ao criar o diretório",
							"icon"		=>	"error"
						];
						return json_encode($alerta);
		                exit();
		            } 
		        }

		        # Verificando se o formato da imagem é compatível #
		        if(mime_content_type($_FILES['usuario_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['usuario_foto']['tmp_name'])!="image/png"){
		        	$alerta=[
						"tipo"		=>	"simple",
						"titulo"	=>	"Ihhh, a wild error appears! :(",
						"texto"		=>	"A imagem está em um formato não permitido",
						"icon"		=>	"error"
					];
					return json_encode($alerta);
		            exit();
		        }

		        # Verificando peso/tamanho de imagem #
		        if(($_FILES['usuario_foto']['size']/1024)>5120){
		        	$alerta=[
						"tipo"		=>	"simple",
						"titulo"	=>	"Ihhh, a wild error appears! :(",
						"texto"		=>	"Essa imagem é muito grande",
						"icon"		=>	"error"
					];
					return json_encode($alerta);
		            exit();
		        }

		        # Nome da foto #
		        $foto=str_ireplace(" ","_",$nome);
		        $foto=$foto."_".rand(0,100);

		        # Extensão da imagem #
		        switch(mime_content_type($_FILES['usuario_foto']['tmp_name'])){
		            case 'image/jpeg':
		                $foto=$foto.".jpg";
		            break;
		            case 'image/png':
		                $foto=$foto.".png";
		            break;
		        }

		        chmod($img_dir,0777);

		        # Movendo a imagem ao diretório de imagens #
		        if(!move_uploaded_file($_FILES['usuario_foto']['tmp_name'],$img_dir.$foto)){
		        	$alerta=[
						"tipo"		=>	"simple",
						"titulo"	=>	"Ihhh, a wild error appears! :(",
						"texto"		=>	"Não conseguimos fazer o Upload da imagem neste momento",
						"icon"		=>	"error"
					];
					return json_encode($alerta);
		            exit();
		        }

    		} else {
    			$foto="";
    		}


		    $usuario_datos_reg=[
				[
					"campo_nombre"		=>	"usuario_nome",
					"campo_marcador"	=>	":Nombre",
					"campo_valor"		=>	$nome
				],
				[
					"campo_nombre"		=>	"usuario_description",
					"campo_marcador"	=>	":Apellido",
					"campo_valor"		=>	$descricao
				],
				[
					"campo_nombre"		=>	"usuario_usuario",
					"campo_marcador"	=>	":Usuario",
					"campo_valor"		=>	$usuario
				],
				[
					"campo_nombre"		=>	"usuario_email",
					"campo_marcador"	=>	":Email",
					"campo_valor"		=>	$email
				],
				[
					"campo_nombre"		=>	"usuario_cpf",
					"campo_marcador"	=>	":Clave",
					"campo_valor"		=>	$senha
				],
				[
					"campo_nombre"		=>	"usuario_foto",
					"campo_marcador"	=>	":Foto",
					"campo_valor"		=>	$foto
				],
				[
					"campo_nombre"		=>	"usuario_criado",
					"campo_marcador"	=>	":Creado",
					"campo_valor"		=>	date("Y-m-d H:i:s")
				],
				[
					"campo_nombre"		=>	"usuario_atualizado",
					"campo_marcador"	=>	":Actualizado",
					"campo_valor"		=>	date("Y-m-d H:i:s")
				]
			];

			$registrar_usuario=$this->savingDatas("usuario",$usuario_datos_reg);

			if($registrar_usuario->rowCount()==1){
				$alerta=[
					"tipo"		=>	"limpiar",
					"titulo"	=>	"Contato salvo com sucesso! :)",
					"texto"		=>	"O contato ".$nome." ".$descricao." foi adicionado a sua lista",
					"icon"		=>	"success"
				];
			} else {
				
				if(is_file($img_dir.$foto)){
		            chmod($img_dir.$foto,0777);
		            unlink($img_dir.$foto);
		        }

				$alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"Não foi possível salvar o contato, tente novamente mais tarde",
					"icon"		=>	"error"
				];
			}

			return json_encode($alerta);

		}



		/*----------  Controlador listar usuario  ----------*/
		public function listarUsuarioControlador($pagina,$registros,$url,$pesquisa){

			$pagina=$this->cleanString($pagina);
			$registros=$this->cleanString($registros);

			$url=$this->cleanString($url);
			$url=APP_URL.$url."/";

			$pesquisa=$this->cleanString($pesquisa);
			$table="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

			if(isset($pesquisa) && $pesquisa!=""){

				$consulta_datos="SELECT * FROM usuario WHERE ((usuario_id!='".$_SESSION['id']."' AND usuario_id!='1') AND (usuario_nome LIKE '%$pesquisa%' OR usuario_description LIKE '%$pesquisa%' OR usuario_email LIKE '%$pesquisa%' OR usuario_usuario LIKE '%$pesquisa%')) ORDER BY usuario_nome ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(usuario_id) FROM usuario WHERE ((usuario_id!='".$_SESSION['id']."' AND usuario_id!='1') AND (usuario_nome LIKE '%$pesquisa%' OR usuario_description LIKE '%$pesquisa%' OR usuario_email LIKE '%$pesquisa%' OR usuario_usuario LIKE '%$pesquisa%'))";

			} else {

				$consulta_datos="SELECT * FROM usuario WHERE usuario_id!='".$_SESSION['id']."' AND usuario_id!='1' ORDER BY usuario_nome ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(usuario_id) FROM usuario WHERE usuario_id!='".$_SESSION['id']."' AND usuario_id!='1'";

			}

			$dados 			= $this->runQuery($consulta_datos);
			$dados 			= $dados->fetchAll();

			$total 			= $this->runQuery($consulta_total);
			$total 			= (int) $total->fetchColumn();

			$numeroPaginas 	= ceil($total/$registros);

			$table.='
		        <div class="table-container">
		        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
		            <thead>
		                <tr>
		                    <th class="has-text-centered">#</th>
		                    <th class="has-text-centered">Nome</th>
		                    <th class="has-text-centered">Descrição</th>
		                    <th class="has-text-centered">Email</th>
		                    <th class="has-text-centered">Criado</th>
		                    <th class="has-text-centered">Atualizado em</th>
		                    <th class="has-text-centered" colspan="3">Opções</th>
		                </tr>
		            </thead>
		            <tbody>
		    ';

		    if($total>=1 && $pagina<=$numeroPaginas){
				$contador		=$inicio+1;
				$pag_inicio		=$inicio+1;
				
				foreach($dados as $rows){
					$table.='
						<tr class="has-text-centered" >
							<td>'.$contador.'</td>
							<td>'.$rows['usuario_nome'].'</td>
							<td>'.$rows['usuario_description'].'</td>
							
							<td>'.$rows['usuario_email'].'</td>
							<td>'.date("d-m-Y  h:i:s A",strtotime($rows['usuario_criado'])).'</td>
							<td>'.date("d-m-Y  h:i:s A",strtotime($rows['usuario_atualizado'])).'</td>
							<td>
			                    <a href="'.APP_URL.'userPhoto/'.$rows['usuario_id'].'/" class="button is-info is-rounded is-small">Foto</a>
			                </td>
			                <td>
			                    <a href="'.APP_URL.'userUpdate/'.$rows['usuario_id'].'/" class="button is-success is-rounded is-small">Atualizar</a>
			                </td>
			                <td>
			                	<form class="FormularioAjax" action="'.APP_URL.'app/ajax/usuarioAjax.php" method="POST" autocomplete="off" >

			                		<input type="hidden" name="modulo_usuario" value="deletar">
			                		<input type="hidden" name="usuario_id" value="'.$rows['usuario_id'].'">

			                    	<button type="submit" class="button is-danger is-rounded is-small">Deletar</button>
			                    </form>
			                </td>
						</tr>
					';
					$contador++;
				}
				$pag_final=$contador-1;
			} else {
				if($total>=1){
					$table.='
						<tr class="has-text-centered" >
			                <td colspan="7">
			                    <a href="'.$url.'1/" class="button is-link is-rounded is-small mt-4 mb-4">
			                        Clique aqui para recarregar a lista
			                    </a>
			                </td>
			            </tr>
					';
				} else {
					$table.='
						<tr class="has-text-centered" >
			                <td colspan="7">
			                    Você ainda não possui contatos :(
			                </td>
			            </tr>
					';
				}
			}

			$table.='</tbody></table></div>';

			### Paginação###
			if($total>0 && $pagina<=$numeroPaginas){
				$table.='<p class="has-text-right">Mostrando contatos <strong>'.$pag_inicio.'</strong> a <strong>'.$pag_final.'</strong> de um <strong>total de '.$total.'</strong></p>';

				$table.=$this->paginadorTabelas($pagina,$numeroPaginas,$url,7);
			}

			return $table;
		}


		/*----------  Controlador para deletar usuario  ----------*/
		public function deletarUsuarioControlador(){

			$id=$this->cleanString($_POST['usuario_id']);

			if($id==1){
				$alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"Não podemos deletar o usuário principal do sistema",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
		        exit();
			}

			# Verificando usuario #
		    $dados=$this->runQuery("SELECT * FROM usuario WHERE usuario_id='$id'");
		    if($dados->rowCount()<=0){
		        $alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"Não encontramos esse usuário",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
		        exit();
		    } else {
		    	$dados=$dados->fetch();
		    }

		    $eliminarUsuario=$this->deletarRegistro("usuario","usuario_id",$id);

		    if($eliminarUsuario->rowCount()==1){

		    	if(is_file("../views/fotos/".$dados['usuario_foto'])){
		            chmod("../views/fotos/".$dados['usuario_foto'],0777);
		            unlink("../views/fotos/".$dados['usuario_foto']);
		        }

		        $alerta=[
					"tipo"		=>	"recargar",
					"titulo"	=>	"O contato foi deletado! :)",
					"texto"		=>	"O contato ".$dados['usuario_nome']." ".$dados['usuario_description']." foi deletado com sucesso!",
					"icon"		=>	"success"
				];

		    } else {

		    	$alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"Não conseguimos deletar o contato de ".$dados['usuario_nome']." ".$dados['usuario_description']." do nosso sistema",
					"icon"		=>	"error"
				];
		    }

		    return json_encode($alerta);
		}


		/*----------  Controlador atualizar info de contato  ----------*/
		public function updateUserController(){

			$id=$this->cleanString($_POST['usuario_id']);

			# Verificando usuario #
		    $dados=$this->runQuery("SELECT * FROM usuario WHERE usuario_id='$id'");
		    if($dados->rowCount()<=0){
		        $alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"Não encontramos esse contato no sistema",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
		        exit();
		    } else {
		    	$dados=$dados->fetch();
		    }

		    $admin_usuario=$this->cleanString($_POST['administrador_usuario']);
		    $admin_clave=$this->cleanString($_POST['administrador_clave']);

		    # Verificando campos obrigatórios de administrador #
		    if($admin_usuario=="" || $admin_clave==""){
		        $alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"Todos os campos obrigatórios devem ser preenchidos",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDados("[a-zA-Z0-9]{4,20}",$admin_usuario)){
		        $alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"O contato não coincide com o solicitado",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDados("[a-zA-Z0-9$@.-]{7,100}",$admin_clave)){
		    	$alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"A sua senha não corresponde",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Verificando administrador #
		    $check_admin=$this->runQuery("SELECT * FROM usuario WHERE usuario_usuario='$admin_usuario' AND usuario_id='".$_SESSION['id']."'");
		    if($check_admin->rowCount()==1){

		    	$check_admin=$check_admin->fetch();

		    	if($check_admin['usuario_usuario']!=$admin_usuario || !password_verify($admin_clave,$check_admin['usuario_cpf'])){

		    		$alerta=[
						"tipo"		=>	"simple",
						"titulo"	=>	"Ihhh, a wild error appears! :(",
						"texto"		=>	"Login e senha estão erradas",
						"icon"		=>	"error"
					];
					return json_encode($alerta);
		        	exit();
		    	}
		    } else {
		        $alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"Login e senha estão erradas",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
		        exit();
		    }


			# Armazenando dados#
		    $nome				=$this->cleanString($_POST['usuario_nome']);
		    $descricao			=$this->cleanString($_POST['usuario_description']);
		    $usuario			=$this->cleanString($_POST['usuario_usuario']);
		    $email				=$this->cleanString($_POST['usuario_email']);
		    $senha1				=$this->cleanString($_POST['usuario_cpf_1']);
		    $senha2				=$this->cleanString($_POST['usuario_cpf_2']);

		    # Verificando campos obrigatórios #
		    if($nome=="" || $descricao=="" || $usuario==""){
		        $alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"Os campos obrigatórios não foram preenchidos",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Verificando a integridade dos dados #
		    if($this->verificarDados("[a-zA-ZáàâãéêíóôõúçñÑ  ]{3,40}",$nome)){
		        $alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"O nome não coincide com o solicitado",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDados("[a-zA-ZáàâãéêíóôõúçñÑ  ]{3,40}",$descricao)){
		        $alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"A descrição não coincide com o que foi dito",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDados("[a-zA-Z0-9]{4,20}",$usuario)){
		    	$alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"O usuário está errado",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Verificando email #
		    if($email!="" && $dados['usuario_email']!=$email){
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					$check_email=$this->runQuery("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
					if($check_email->rowCount()>0){
						$alerta=[
							"tipo"		=>	"simple",
							"titulo"	=>	"Ihhh, a wild error appears! :(",
							"texto"		=>	"Este e-mail já está cadastrado no sistema",
							"icon"		=>	"error"
						];
						return json_encode($alerta);
						exit();
					}
				} else {
					$alerta=[
						"tipo"		=>	"simple",
						"titulo"	=>	"Ihhh, a wild error appears! :(",
						"texto"		=>	"Digite um e-mail válido",
						"icon"		=>	"error"
					];
					return json_encode($alerta);
					exit();
				}
            }

            # Verificando as "senhas" que servem como CPF #
            if($senha1!="" || $senha2!=""){
            	if($this->verificarDados("[a-zA-Z0-9$@.-]{7,100}",$senha1) || $this->verificarDados("[a-zA-Z0-9$@.-]{7,100}",$senha2)){

			        $alerta=[
						"tipo"		=>	"simple",
						"titulo"	=>	"Ihhh, a wild error appears! :(",
						"texto"		=>	"As senhas não coincidem",
						"icon"		=>	"error"
					];
					return json_encode($alerta);
			        exit();
			    } else {
			    	if($senha1!=$senha2){

						$alerta=[
							"tipo"		=>	"simple",
							"titulo"	=>	"Ihhh, a wild error appears! :(",
							"texto"		=>	"As senhas não coincidem",
							"icon"		=>	"error"
						];
						return json_encode($alerta);
						exit();
			    	} else {
			    		$senha=password_hash($senha1,PASSWORD_BCRYPT,["cost"=>10]);
			    	}
			    }
			} else {
				$senha=$dados['usuario_cpf'];
            }

            # Verificando usuario #
            if($dados['usuario_usuario']!=$usuario){
			    $check_usuario=$this->runQuery("SELECT usuario_usuario FROM usuario WHERE usuario_usuario='$usuario'");
			    if($check_usuario->rowCount()>0){
			        $alerta=[
						"tipo"		=>	"simple",
						"titulo"	=>	"Ihhh, a wild error appears! :(",
						"texto"		=>	"Este nome de contato já está registrado",
						"icon"		=>	"error"
					];
					return json_encode($alerta);
			        exit();
			    }
            }

            $usuario_datos_up=[
				[
					"campo_nombre"		=>	"usuario_nome",
					"campo_marcador"	=>	":Nombre",
					"campo_valor"		=>	$nome
				],
				[
					"campo_nombre"		=>	"usuario_description",
					"campo_marcador"	=>	":Apellido",
					"campo_valor"		=>	$descricao
				],
				[
					"campo_nombre"		=>	"usuario_usuario",
					"campo_marcador"	=>	":Usuario",
					"campo_valor"		=>	$usuario
				],
				[
					"campo_nombre"		=>	"usuario_email",
					"campo_marcador"	=>	":Email",
					"campo_valor"		=>	$email
				],
				[
					"campo_nombre"		=>	"usuario_cpf",
					"campo_marcador"	=>	":Clave",
					"campo_valor"		=>	$senha
				],
				[
					"campo_nombre"		=>	"usuario_atualizado",
					"campo_marcador"	=>	":Actualizado",
					"campo_valor"		=>	date("Y-m-d H:i:s")
				]
			];

			$condition=[
				"condicion_campo"		=>	"usuario_id",
				"condicion_marcador"	=>	":ID",
				"condicion_valor"		=>	$id
			];

			if($this->updateDatas("usuario",$usuario_datos_up,$condition)){

				if($id==$_SESSION['id']){
					
					$_SESSION['nombre']		=$nome;
					$_SESSION['apellido']	=$descricao;
					$_SESSION['usuario']	=$usuario;
				}

				$alerta=[
					"tipo"		=>	"recargar",
					"titulo"	=>	"Os dados do contato foi atualizado! :)",
					"texto"		=>	"Os dados de ".$dados['usuario_nome']." ".$dados['usuario_description']." foram atualizados",
					"icon"		=>	"success"
				];
			} else {
				$alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"Não conseguimos atualizados os dados de ".$dados['usuario_nome']." ".$dados['usuario_description'].", por favor tente novamente",
					"icon"		=>	"error"
				];
			}

			return json_encode($alerta);
		}


		/*----------  Controlador para deletar foto usuario  ----------*/
		public function deletarFotoUsuarioControlador(){

			$id			=$this->cleanString($_POST['usuario_id']);

			# Verificando usuario #
		    $dados		=$this->runQuery("SELECT * FROM usuario WHERE usuario_id='$id'");
		    
			if($dados->rowCount()<=0){
		        $alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"Não encontramos esse contato",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
		        exit();
		    } else {
		    	$dados=$dados->fetch();
		    }

		    # Diretorio de imagens #
    		$img_dir="../views/fotos/";

    		chmod($img_dir,0777);

    		if(is_file($img_dir.$dados['usuario_foto'])){

		        chmod($img_dir.$dados['usuario_foto'],0777);

		        if(!unlink($img_dir.$dados['usuario_foto'])){
		            $alerta=[
						"tipo"		=>	"simple",
						"titulo"	=>	"Ihhh, a wild error appears! :(",
						"texto"		=>	"Não foi possível deletar a foto do contato",
						"icon"		=>	"error"
					];
					return json_encode($alerta);
		        	exit();
		        }
		    } else {
		    	$alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"Não achamos este contato",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    $usuario_datos_up=[
				[
					"campo_nombre"		=>	"usuario_foto",
					"campo_marcador"	=>	":Foto",
					"campo_valor"		=>	""
				],
				[
					"campo_nombre"		=>	"usuario_atualizado",
					"campo_marcador"	=>	":Actualizado",
					"campo_valor"		=>	date("Y-m-d H:i:s")
				]
			];

			$condition=[
				"condicion_campo"		=>	"usuario_id",
				"condicion_marcador"	=>	":ID",
				"condicion_valor"		=>	$id
			];

			if($this->updateDatas("usuario",$usuario_datos_up,$condition)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']="";
				}

				$alerta=[
					"tipo"		=>	"recargar",
					"titulo"	=>	"Foto deletada com sucesso! :)",
					"texto"		=>	"A foto de ".$dados['usuario_nome']." ".$dados['usuario_description']." foi deletada",
					"icon"		=>	"success"
				];
			} else {
				$alerta=[
					"tipo"		=>	"recargar",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"Não conseguimos deletar a foto de ".$dados['usuario_nome']." ".$dados['usuario_description'].", tente novamente",
					"icon"		=>	"warning"
				];
			}

			return json_encode($alerta);
		}


		/*----------  Controlador atualizar a foto usuario  ----------*/
		public function atualizarFotoUsuarioControlador(){

			$id			=$this->cleanString($_POST['usuario_id']);

			# Verificando usuario #
		    $dados		=$this->runQuery("SELECT * FROM usuario WHERE usuario_id='$id'");
		    if($dados->rowCount()<=0){
		        $alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"Não encontramos esse usuário no sistema",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
		        exit();
				
		    } else {
		    	$dados=$dados->fetch();
		    }

		    # Diretorio de imagens #
    		$img_dir="../views/fotos/";

    		# Comprovar se selecionei uma imagem #
    		if($_FILES['usuario_foto']['name']=="" && $_FILES['usuario_foto']['size']<=0){
    			$alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"Este usuário não tem foto",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
		        exit();
    		}

    		# Criando um diretorio #
	        if(!file_exists($img_dir)){
	            if(!mkdir($img_dir,0777)){
	                $alerta=[
						"tipo"		=>	"simple",
						"titulo"	=>	"Ihhh, a wild error appears! :(",
						"texto"		=>	"Erro ao salvar a foto",
						"icon"		=>	"error"
					];
					return json_encode($alerta);
	                exit();
	            } 
	        }

	        # Verificando formato das imagens #
	        if(mime_content_type($_FILES['usuario_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['usuario_foto']['tmp_name'])!="image/png"){
	            $alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"Essa imagem tem um formato não permitido",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
	            exit();
	        }

	        # Verificando peso/tamanho da imagem #
	        if(($_FILES['usuario_foto']['size']/1024)>5120){
	            $alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"A imagem selecionada é muito pesada",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
	            exit();
	        }

	        # Criando o nome da foto #
	        if($dados['usuario_foto']!=""){
		        $foto=explode(".", $dados['usuario_foto']);
		        $foto=$foto[0];
	        } else {
	        	$foto=str_ireplace(" ","_",$dados['usuario_nome']);
	        	$foto=$foto."_".rand(0,100);
	        }
	        

	        # Extensão da imagem - JPEG ou PNG #
	        switch(mime_content_type($_FILES['usuario_foto']['tmp_name'])){
	            case 'image/jpeg':
	                $foto=$foto.".jpg";
	            break;
	            case 'image/png':
	                $foto=$foto.".png";
	            break;
	        }

	        chmod($img_dir,0777);

	        # Movendo a imagem pra dentro do diretório #
	        if(!move_uploaded_file($_FILES['usuario_foto']['tmp_name'],$img_dir.$foto)){
	            $alerta=[
					"tipo"		=>	"simple",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"Não conseguimos fazer o upload da imagem",
					"icon"		=>	"error"
				];
				return json_encode($alerta);
	            exit();
	        }

	        # Deletando a imagem anterior do contato/usuario #
	        if(is_file($img_dir.$dados['usuario_foto']) && $dados['usuario_foto']!=$foto){
		        chmod($img_dir.$dados['usuario_foto'], 0777);
		        unlink($img_dir.$dados['usuario_foto']);
		    }

		    $usuario_datos_up=[
				[
					"campo_nombre"		=>	"usuario_foto",
					"campo_marcador"	=>	":Foto",
					"campo_valor"		=>	$foto
				],
				[
					"campo_nombre"		=>	"usuario_atualizado",
					"campo_marcador"	=>	":Actualizado",
					"campo_valor"		=>	date("Y-m-d H:i:s")
				]
			];

			$condition=[
				"condicion_campo"		=>	"usuario_id",
				"condicion_marcador"	=>	":ID",
				"condicion_valor"		=>	$id
			];

			if($this->updateDatas("usuario",$usuario_datos_up,$condition)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']=$foto;
				}

				$alerta=[
					"tipo"		=>	"recargar",
					"titulo"	=>	"Foto atualizada!! :)",
					"texto"		=>	"A foto de ".$dados['usuario_nome']." ".$dados['usuario_description']." foi atualizada com sucesso",
					"icon"		=>	"success"
				];
			} else {

				$alerta=[
					"tipo"		=>	"recargar",
					"titulo"	=>	"Ihhh, a wild error appears! :(",
					"texto"		=>	"Não conseguimos atualizar a foto de ".$dados['usuario_nome']." ".$dados['usuario_description']." , tente novamente",
					"icon"		=>	"warning"
				];
			}

			return json_encode($alerta);
		}

	}