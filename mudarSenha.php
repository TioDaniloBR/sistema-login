<?php
require_once 'core/init.php';

$usuario = new Usuario();

if(!$usuario->estaLogado())
{
    Redirecionar::para('index.php');
}
if(Input::existe())
{
    if(Token::checarToken(Input::get('token')))
    {
        $validar = new Validacao();
        $validacao = $validar->checar($_POST,array(
            'password_atual' => array(
                'nomeCampo' => 'Password atual',
                'required' => true,
            ),
            'password_novo' => array(
                'nomeCampo' => 'Novo password',
                'required' => true,
                'min' => 6,
            ),
            're_password_novo' => array(
                'nomeCampo' => 'Password novamente',
                'required' => true,
                'igual' => 'password_novo'
            )
        ));
        if($validacao->passou())
        {
            $usuario = new Usuario();
            if(Criptografia::criar(Input::get('password_atual'),$usuario->dados()->salt) !== $usuario->dados()->password)
            {
                echo 'Senha atual está incorreta.';
            }else{
                $salt = Criptografia::salt(1608);
                $usuario->update(array(
                    'password' => Criptografia::criar(Input::get('password_novo'),$salt),
                    'salt' => $salt
                ));
                Sessao::flash('home','Sua senha foi alterada com sucesso.');
                Redirecionar::para('index.php');
            }
        }else{
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
    <title>Mudar Senha</title>
</head>
<body class="text-center">
    <form action="" class="form-signin" method="post">
        <h1 class="h3 mb-4 mt-4 font-weight-normal">Mudar senha.</h1>
        <p>Olá <?php echo $usuario->dados()->nome; ?>, Preencha os campos abaixo para mudar sua senha </p>
        <label for="password_atual">Senha atual</label>
        <input type="password" name="password_atual" id="password_atual" class="form-control">
        <label for="password_novo">Insira a nova senha</label>
        <input type="password" name="password_novo" id="password_novo" class="form-control">
        <label for="re_password_novo">Insira a nova senha novamente</label>
        <input type="password" name="re_password_novo" id="re_password_novo" class="form-control">
        
        <input type="hidden" name="token" value="<?php echo Token::gerarToken(); ?>">
        <input type="submit" value="Enviar" class="btn btn-primary btn-block mt-4">
    </form>
</body>
</html>