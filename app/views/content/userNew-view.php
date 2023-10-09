<div class="container is-fluid mb-6">
	<h1 class="title">Contatos</h1>
	<h2 class="subtitle">Adicionar novo contato</h2>
</div>

<div class="container pb-6 pt-6">

	<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data" >

		<input type="hidden" name="modulo_usuario" value="registrar">

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nome do contato</label>
				  	<input class="input" type="text" name="usuario_nome" maxlength="40" required >
				</div>
		  	</div>

		  	<div class="column">
		    	<div class="control">
					<label>Descrição</label>
				  	<input class="input" type="text" name="usuario_description" maxlength="40" required >
				</div>
		  	</div>
		</div>

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Username</label>
				  	<input class="input" type="text" name="usuario_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Email</label>
				  	<input class="input" type="text" name="usuario_email" maxlength="70" >
				</div>
		  	</div>
		</div>
		
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>CPF</label>
				  	<input class="input" type="number" name="usuario_cpf_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Repetir CPF</label>
				  	<input class="input" type="number" name="usuario_cpf_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
				<div class="file has-name is-boxed">
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
		  	</div>
		</div>
		<p class="has-text-centered">
			<a href="#" class="button is-link is-rounded btn-back" style="background-color: #ff5733; color: #fff;">Cancelar</a>
			<button type="submit" class="button is-info is-rounded">Salvar</button>
		</p>
	</form>
</div>

<script type="text/javascript">
    let btn_back = document.querySelector(".btn-back");

    btn_back.addEventListener('click', function(e){
        e.preventDefault();
        window.history.back();
    });
</script>