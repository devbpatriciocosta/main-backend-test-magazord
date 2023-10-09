<nav class="navbar">
    <div class="navbar-brand">
        <a class="navbar-item" href="<?php echo APP_URL; ?>dashboard/">
            <img src="<?php echo APP_URL; ?>app/views/img/logo-magazord.png" alt="logo-magazord" width="112" height="116">
        </a>
        <div class="navbar-burger" data-target="navbarExampleTransparentExample">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div id="navbarExampleTransparentExample" class="navbar-menu">

        <div class="navbar-start">
            <a class="navbar-item" href="<?php echo APP_URL; ?>dashboard/">
                Início
            </a>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link" href="#">
                    Contatos
                </a>
                <div class="navbar-dropdown is-boxed">

                    <a class="navbar-item" href="<?php echo APP_URL; ?>userNew/">
                        Adicionar Contatos
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>userList/">
                        Meus contatos
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>userSearch/">
                        Pesquisar Contato
                    </a>

                </div>
            </div>
        </div>

        <div class="navbar-end">
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    <?php echo $_SESSION['usuario']; ?>
                </a>
                <div class="navbar-dropdown is-boxed">

                    <a class="navbar-item" href="<?php echo APP_URL."userUpdate/".$_SESSION['id']."/"; ?>">
                        Minha conta
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL."userPhoto/".$_SESSION['id']."/"; ?>">
                        Minha foto
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="<?php echo APP_URL."logOut/"; ?>" id="btn_exit" >
                        Sair
                    </a>

                </div>
            </div>
        </div>

    </div>
</nav>