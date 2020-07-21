<?php
require_once 'core/init.php';

if(Sessao::existe('home'))
{
    echo Sessao::flash('home');
}

$usuario = new Usuario();
if($usuario->estaLogado())
{
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="_css/estilo.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <title>Inicio</title>
    </head>
    <body>
        <p>Olá <a href="profile.php?username=<?php echo $usuario->dados()->username; ?>"><?php echo $usuario->dados()->username; ?></a></p>
        <ul><a href="update.php">Atualizar dados</a></ul>
        <ul><a href="mudarSenha.php">Mudar senha</a></ul>
        <ul><a href="logout.php">Logout</a></ul>
    </body>
    </html>
    <?php
}else{
    echo "Você precisa <a href='login.php'>logar</a> no sistema.";
}