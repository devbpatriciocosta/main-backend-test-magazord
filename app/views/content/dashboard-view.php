<div class="container is-fluid">
	<h1 class="title">Página Inicial</h1>

  	<div class="columns is-flex is-justify-content-center">
  		<h2 class="subtitle" style="text-align: center; margin-bottom: 50px; margin-top:50px; font-size:50px;"><?php echo $_SESSION['nombre'].", ".$_SESSION['apellido']; ?> <br> Seja bem-vindo a sua lista de contatos da Magazord!</h2>
  	</div>

	  <div class="columns is-flex is-justify-content-center">
    	<figure class="image is-128x128">
    		<?php
    			if(is_file("./app/views/fotos/".$_SESSION['foto'])){
    				echo '<img class="is-rounded" src="'.APP_URL.'app/views/fotos/'.$_SESSION['foto'].'">';
    			} else {
    				echo '<img class="is-rounded" src="'.APP_URL.'app/views/fotos/megazord.png">';
    			}
    		?>
		</figure>
  	</div>
</div>
