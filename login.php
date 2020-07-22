<?php
    require_once 'core/init.php';
    if(Input::existe())
    {
        if(Token::checarToken(Input::get('token')))
        {
            //implementar validação dos dados
            $validar = new Validacao();
            $validacao = $validar->checar($_POST, array(
                'username' => array(
                    'nomeCampo' => 'username',
                    'required' => true
                ),
                'password' => array(
                    'nomeCampo' => 'password',
                    'required' => true
                )
            ));
            if($validacao->passou())//se a validação dos dados passou
            {
                $usuario = new Usuario();
                $login = $usuario->login(Input::get('username'),Input::get('password'));

                if($login)
                {
                    Redirecionar::para('index.php');
                }else{
                    echo "Não foi possível logar.";
                }
            }else{
                //erros de validação
                foreach($validacao->erros() as $erro)
                {
                    echo $erro."<br>";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="_css/estilo.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <title>Login</title>
</head>
<body class="text-center">
    <form action="" class="form-signin" method="post">
        <h1 class="h3 mb-4 mt-4 font-weight-normal">Por favor, logar-se.</h1>
        <label for="username">Usuário</label>
        <input type="text" name="username" id="username" class="form-control">
        <label for="password">Senha</label>
        <input type="password" name="password" id="password" class="form-control">
        <input type="hidden" name="token" value="<?php echo Token::gerarToken(); ?>">
        <input type="submit" value="Enviar" class="btn btn-primary btn-block mt-4">
        <p id="ainda">Ainda não é cadastrado? Clique <a href="registro.php">aqui.</a></p>
    </form>
    
    
</body>
</html>