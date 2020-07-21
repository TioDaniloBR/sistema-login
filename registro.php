<?php
require_once 'core/init.php';

if(Input::existe())
{
    if(Token::checarToken(Input::get('token')))
    {
        //criar as regras de validação dos campos
        $validar = new Validacao();
        $validacao = $validar->checar($_POST, array(
            'username' =>array(
                'nomeCampo' => 'nome de usuário',
                'required' => true,
                'min' => 4,
                'max' => 20,
                'unico' => 'usuarios'
            ),
            'password' => array(
                'nomeCampo' => 'senha',
                'required' => true,
                'min' => 6
            ),
            're_password' => array(
                'nomeCampo' => 'Repetir senha',
                'igual' => 'password'
            ),
            'nome' => array(
                'nomeCampo' => 'Nome',
                'required' => true,
                'min' => 3,
                'max' => 120
            )
        ));
        if($validacao->passou())//se a validação passou
        {
            $usuario = new Usuario();
            $salt = Criptografia::salt(1608);
            try
            {
                $teste = array(
                    'username'=> Input::get('username'),
                    'password'=> Criptografia::criar(Input::get('password'),$salt),
                    'nome'=> Input::get('nome'),
                    'email'=> Input::get('email'),
                    'joined'=> date_create()->format('Y-m-d H:i:s'),
                    'salt'=> $salt
                );
                var_dump($teste);
                $usuario->create($teste);
                Sessao::flash('home','Registro efetuado com sucesso.');
                Redirecionar::para('index.php');
            }catch(Exception $e){
                die($e->getMessage());
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
    <title>Cadastro</title>
</head>
<body class="text-center">
    <form action="" class="form-signin" method="post">
        <h1 class="h3 mb-4 mt-4 font-weight-normal">Cadastre-se.</h1>
        <label for="username">Usuário</label>
        <input type="text" name="username" id="username" class="form-control">
        <label for="password">Senha</label>
        <input type="password" name="password" id="password" class="form-control">
        <label for="re_password">Insira a senha novamente</label>
        <input type="password" name="re_password" id="re_password" class="form-control">
        <label for="username">Nome</label>
        <input type="text" name="nome" id="nome" class="form-control">
        <label for="username">Email</label>
        <input type="email" name="email" id="email" class="form-control">
        <input type="hidden" name="token" value="<?php echo Token::gerarToken(); ?>">
        <input type="submit" value="Enviar" class="btn btn-primary btn-block mt-4">
    </form>
</body>
</html>