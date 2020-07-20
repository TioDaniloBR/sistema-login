<?php

session_start();

$GLOBALS['config'] = array(
    'mysql' => array(
        'host'      => 'localhost',
        'username'  => 'root',
        'password'  => '',
        'db'        => 'users_login'
    ),
    'sessao' => array(
        'nomeSessao' => 'usuario'
    )
);

spl_autoload_register(function($classe){
    require_once 'classes/'.$classe.'.php';
});