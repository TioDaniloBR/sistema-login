<?php
date_default_timezone_set('America/Sao_Paulo');
session_start();
if(count($_SESSION)>0){
    if(isset($_SESSION['ultimaAcao'])){
        if(($_SESSION['ultimaAcao']+2000) < time()){
            session_destroy();
            header('Location:index.php');
        }else{
            $_SESSION['ultimaAcao'] = time();        
        }
    }else{
    $_SESSION['ultimaAcao'] = time();
    }
}


$GLOBALS['config'] = array(
    'mysql' => array(
        'host'      => 'localhost',
        'username'  => 'root',
        'password'  => '',
        'db'        => 'users_login'
    ),
    'sessao' => array(
        'nomeSessao' => 'usuario',
        'nomeToken' => 'token'
    )
);

spl_autoload_register(function($classe){
    require_once 'classes/'.$classe.'.php';
});