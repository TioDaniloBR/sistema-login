<?php
require_once 'core/init.php';

if(!$username = Input::get('username'))
{
    Redirecionar::para('index.php');
}else{
    $usuario = new Usuario($username);
    if(!$usuario->existe())
    {
        Redirecionar::para(404);
    }else{
        $dados = $usuario->dados();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="_css/estilo.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <title>Profile</title>
</head>
<body>
    <div>
        <p>Nome: <?php echo $dados->nome; ?></p>
        <p>Email: <?php echo $dados->email; ?></p>
        <p>Username: <?php echo $dados->username; ?></p>
        <p>Usuário desde: <?php echo date('d/m/Y',strtotime($dados->joined)); ?></p>
    </div>
</body>
</html>
<?php
}
?>