<div class="container is-fluid mb-6">
    <h1 class="title">Contatos</h1>
    <h2 class="subtitle">Pesquisar um contato</h2>
</div>

<div class="container pb-6 pt-6">

    <?php
    
        use app\controllers\userController;
        
        $insUser = new userController();

        if(!isset($_SESSION[$url[0]]) && empty($_SESSION[$url[0]])){
    ?>

    <div class="columns">
        <div class="column">
            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/searcherAjax.php" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="pesquisar">
                <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">

                <div class="field is-grouped">
                    <p class="control is-expanded">
                        <input class="input is-rounded" type="text" name="txt_buscador" placeholder="Quem você procura?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30" required >
                    </p>

                    <p class="control">
                        <button class="button is-info" type="submit" >Pesquisar</button>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <?php } else { ?>

    <div class="columns">
        <div class="column">
            <form class="has-text-centered mt-6 mb-6 FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/searcherAjax.php" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="deletar">
                
                <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>"
                    <p>Pesquisando por: <strong>“<?php echo $_SESSION[$url[0]]; ?>”</strong></p>
                <br>
                
                <button type="submit" class="button is-danger is-rounded">Apagar pesquisa</button>
            </form>
        </div>
    </div>
    
    <?php
            echo $insUser->listarUsuarioControlador($url[1],15,$url[0],$_SESSION[$url[0]]);
        }
    ?>
</div>