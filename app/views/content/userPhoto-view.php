<div class="container is-fluid mb-6">
	
	<?php 

		$id=$insLogin->cleanString($url[1]);

		if($id==$_SESSION['id']){ 
	?>

	<h1 class="title">
		Minha foto de perfil
	</h1>
	
	<h2 class="subtitle">
		Atualizar foto de perfil
	</h2>

	<?php 
		
		} else { ?>
			<h1 class="title">
				Contatos
			</h1>
			
			<h2 class="subtitle">
				Atualizar foto de perfil
			</h2>
	<?php 
	
	} ?>
</div>

<div class="container pb-6 pt-6">
	<?php
	
		include "./app/views/inc/btn_back.php";

		$dados		=$insLogin->selecionarDados("Unico","usuario","usuario_id",$id);

		if($dados->rowCount()==1){
			$dados	=$dados->fetch();
	?>

	<h2 class="title has-text-centered"><?php echo $dados['usuario_nome']." - ".$dados['usuario_description']; ?></h2>

	<p class="has-text-centered pb-6"><?php echo "<strong>Criado em:</strong> ".date("d-m-Y  h:i:s A",strtotime($dados['usuario_criado']))." &nbsp;  <strong>Atualizado em:</strong> ".date("d-m-Y  h:i:s A",strtotime($dados['usuario_atualizado'])); ?></p>

	<div class="columns">
		<div class="column is-two-fifths">

            <?php if(is_file("./app/views/fotos/".$dados['usuario_foto'])){ ?>

			<figure class="image mb-6">
                <img class="is-rounded" src="<?php echo APP_URL; ?>app/views/fotos/<?php echo $dados['usuario_foto']; ?>">
			</figure>
			
			<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" autocomplete="off" >

				<input type="hidden" name="modulo_usuario" value="deletarFoto">
				<input type="hidden" name="usuario_id" value="<?php echo $dados['usuario_id']; ?>">

				<p class="has-text-centered">
					<button type="submit" class="button is-danger is-rounded">Deletar foto</button>
				</p>
			</form>

			<?php } else { ?>
			
			<figure class="image mb-6">
			  	<img class="is-rounded" src="<?php echo APP_URL; ?>app/views/fotos/megazord.png">
			</figure>

			<?php }?>
		</div>

		<div class="column">
			<form class="mb-6 has-text-centered FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" enctype="multipart/form-data" autocomplete="off" >

				<input type="hidden" name="modulo_usuario" value="atualizarFoto">
				<input type="hidden" name="usuario_id" value="<?php echo $dados['usuario_id']; ?>">
				
				<label>Foto do contato</label><br>

				<div class="file has-name is-boxed is-justify-content-center mb-6">
				  	<label class="file-label">
						<input class="file-input" type="file" name="usuario_foto" accept=".jpg, .png, .jpeg" >
						<span class="file-cta">
							<span class="file-label">
								Escolha uma foto
							</span>
						</span>
						<span class="file-name">JPG, JPEG, PNG. (MAX 5MB)</span>
					</label>
				</div>

				<p class="has-text-centered">
					<button type="submit" class="button is-success is-rounded">Atualizar foto</button>
				</p>

			</form>
		</div>
	</div>

	<?php
		} else {
			include "./app/views/inc/error_alert.php";
		}
	?>
</div>