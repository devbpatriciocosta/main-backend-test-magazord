<div align='center'>
    Teste para vaga de desenvolvedor back-end no Magazord 

    [Magazord](app/views/img/logo-magazord.png)
</div>

Esse repositório tem como objetivo provar os conhecimentos em JS, PHP e Banco de Dados para a vaga de desenvolvedor Back-End na empresa [Magazord](app/views/img/logo-magazord.png)

## Como configurar e rodar o teste? 
---------------------------------------------------------------------------------------------------------------------------------

1) Baixe/Copie o projeto do [GitHub] ou use o [Git Clone] em seu [terminal];

2) Copie a pasta do projeto em seu servidor local [XAMPP], mais precisamente na pasta [HTDOCS] ou [www];

3) É necessário startar os modulos [Apache] e [MySQL] no [XAMPP Control Panel];

4) Acesse o [PHPmyAdmin] através do [Dashboard] do [localhost]; 

5) Na barra de opções superior, acesse [importar] e escolha o [arquivo] (db.sql) presente na pasta [DB] desse projeto;

6) Acesse http://localhost:8080/main-magazord-backend-test-main/ para acessar o projeto. 

7) Para iniciar sessão basta inserir os dados de [login] e [senha]: Administrador / Administrador, respectivamente. 

---------------------------------------------------------------------------------------------------------------------------------

## Como usar:
 ---------------------------------------------------------------------------------------------------------------------------------
Inicialmente é necessário fazer o login de Administrador - Este faz o cadastro de contatos/usuários;

O Administrador/Usuário pode fazer a adição (INSERT) de novos contatos na aba Contatos no NavBar, selecionando a devida opção;

Os contatos cadastrados pelo administrador se tornam usuários, como se você só tivesse acesso a aplicação por meio de um convite (como nos primórdios do ORKUT); 

O contato, para ter acesso, precisa ter informação de username e CPF, que no caso é a senha - (Obviamente, o usuário pode alterar a sua senha); 

O usuário tem acesso a lista de contatos da Magazord na aba de contatos/Meus contatos (READ);

Na sessão de meus contatos, é possível fazer uma atualização cadastral do contato (UPDATE) e também apagar um registro (DELETE); 

Além do mais, ainda é possível adicionar, atualizar ou apagar a foto do contato; 

Ainda na aba Contatos do NavBar existe a sessão de Pesquisar Contatos - Aqui é possível pesquisar o contato por nome e e-mail e realizar as mesmas ações de READ, UPDATE e DELETE; 

Por fim, no canto direito temos as informações pertinentes ao usuário, como: minha conta, minha foto e sair. 

No minha conta é possível fazer alterações no cadastro (UPDATE) e no minha foto fazer atualização ou deletar a foto. 

No sair a sessão é encerrada, retornando então para a página de login. 

 ## Sobre o projeto:
 ---------------------------------------------------------------------------------------------------------------------------------

Inicialmente o projeto tem uma tela de login que é acessível pelo usuário Administrador / Administrador (Login e senha);

O administrador faz o cadastro de novos contatos através da view 