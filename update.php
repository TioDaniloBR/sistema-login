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
        //implementar validação
        $validar = new Validacao();
        $validacao = $validar->checar($_POST,array(
            'nome'=> array(
                'nomeCampo' => 'Nome',
                'required' => true,
                'min' => 2,
                'max' => 120
            ),
            'email' => array(
                'nomeCampo' => 'Email',
                'required' => true,
                'min' => 3,
                'max' => 120
            )
        ));
        if($validacao->passou())//se a validação passar
        {
            $usuario = new Usuario();
            try{
                $usuario->update(array(
                    'nome' => Input::get('nome'),
                    'email' => Input::get('email')
                ));
                Sessao::flash('home', 'Seus dados foram atualizados');
                Redirecionar::para('index.php');
            }catch(Exception $e){
                die($e->getMessage());
            }
        }else{
            //se a validação falhar
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
    <title>Atualizar dados</title>
</head>
<body>
    <form action="" method="post" class="form-signin">
        <h1>Atualize seus dados</h1>
        <label for="username">Nome</label>
        <input type="text" name="nome" id="nome" class="form-control" value="<?php echo $usuario->dados()->nome; ?>">
        <label for="username">Email</label>
        <input type="text" name="email" id="email" class="form-control" value="<?php echo $usuario->dados()->email; ?>">
        <input type="hidden" name="token" value="<?php echo Token::gerarToken(); ?>">
        <input type="submit" value="Enviar" class="btn btn-primary btn-block mt-4">
    </form>
</body>
</html>