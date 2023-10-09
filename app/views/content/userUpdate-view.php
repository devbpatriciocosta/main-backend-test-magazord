<div class="container is-fluid mb-6">

	<?php 

		$id=$insLogin->cleanString($url[1]);

		if($id==$_SESSION['id']){ 
	?>

		<h1 class="title">
			Minha conta
		</h1>
	
		<h2 class="subtitle">
			Atualizar conta
		</h2>

	<?php } else { ?>
		
		<h1 class="title">
			Contatos
		</h1>
		
		<h2 class="subtitle">
			Atualizar contatos
		</h2>
	
	<?php } ?>

</div>

<div class="container pb-6 pt-6">
	<?php
	
		include "./app/views/inc/btn_back.php";

			$dados		=$insLogin->selecionarDados("Unico","usuario","usuario_id",$id);

			if($dados->rowCount()==1){
			$dados	=$dados->fetch();
	?>

	<h2 class="title has-text-centered">
		<?php echo $dados['usuario_nome']." - ".$dados['usuario_description']; ?>
	</h2>

	<p class="has-text-centered pb-6">
		<?php echo "<strong>Criado em:</strong> ".date("d-m-Y  h:i:s A",strtotime($dados['usuario_criado']))." &nbsp; <strong>Atualizado em:</strong> ".date("d-m-Y  h:i:s A",strtotime($dados['usuario_atualizado'])); ?>
	</p>

	<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" autocomplete="off" >

		<input type="hidden" name="modulo_usuario" value="atualizar">
		<input type="hidden" name="usuario_id" value="<?php echo $dados['usuario_id']; ?>">

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nome</label>
				  	<input class="input" type="text" name="usuario_nome" pattern="[a-zA-ZáàâãéêíóôõúçñÑ ]{3,40}" maxlength="40" value="<?php echo $dados['usuario_nome']; ?>" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Descrição</label>
				  	<input class="input" type="text" name="usuario_description" pattern="[a-zA-ZáàâãéêíóôõúçñÑ ]{3,40}" maxlength="40" value="<?php echo $dados['usuario_description']; ?>" required >
				</div>
		  	</div>
		</div>

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Username</label>
				  	<input class="input" type="text" name="usuario_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" value="<?php echo $dados['usuario_usuario']; ?>" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Email</label>
				  	<input class="input" type="email" name="usuario_email" maxlength="70" value="<?php echo $dados['usuario_email']; ?>" >
				</div>
		  	</div>
		</div>

		<br><br>

		<p class="has-text-centered">
			Caso você deseje atualizar a senha, preencha os dois campos. Caso contrário, deixe os campos vazios. 
		</p>

		<br>

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nova senha</label>
				  	<input class="input" type="password" name="usuario_cpf_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Repetir nova senha</label>
				  	<input class="input" type="password" name="usuario_cpf_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
				</div>
		  	</div>
		</div>

		<br><br><br>

		<p class="has-text-centered">
			Para atualizar os dados desse usuário insira o username e senha que foi usada para iniciar essa sessão
		</p>

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Username</label>
				  	<input class="input" type="text" name="administrador_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Senha</label>
				  	<input class="input" type="password" name="administrador_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
				</div>
		  	</div>
		</div>

		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Atualizar</button>
		</p>

	</form>
	
	<?php
		} else {
			include "./app/views/inc/error_alert.php";
		}
	?>
</div>