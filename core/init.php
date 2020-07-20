<?php

session_start();
if(count($_SESSION)>0){
    $_SESSION['ultimaAcao'] = time();
}
if(isset($_SESSION['ultimaAcao'])){
    if(($_SESSION['ultimaAcao']+60) < time()){
        session_destroy();
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