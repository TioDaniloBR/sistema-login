<?php
require_once 'core/init.php';

if(Sessao::existe('home'))
{
    echo Sessao::flash('home');
}

$usuario = new Usuario();
if($usuario->estaLogado())
{
    echo "Olá ".$usuario->dados()->nome; 
}else{
    echo "Você precisa <a href='login.php'>logar</a> no sistema.";
}