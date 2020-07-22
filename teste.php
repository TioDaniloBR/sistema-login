<?php

require_once 'core/init.php';

$campos = array(
    'nome'=>'Danilo',
    'username'=>'danilo',
    'password'=>'123',
    'email'=>'danilo@danilo.com'
);

// $v = Database::instance();
// $v->update('usuarios', 7, array('username'=>'gothic.joker'));
// echo $v->count();
//$v->delete('usuarios', array('id','=','6'));
//$v->insert("usuarios", $campos);
 //$v->get('usuarios',array('username','=','gothicjoker'));
 //var_dump($v->get('usuarios',array('username','=','gothic.joker')));

 //$var = new Usuario('danilo');
 //var_dump($var->dados());
 //var_dump($var->update(array('username'=>'danilo'),7));

 //echo bin2hex(random_bytes(10));
//  $teste = password_hash(32,PASSWORD_DEFAULT);
 //echo $teste;
//  echo hash("md5","ffutrica");

//var_dump(time());
// var_dump(count($_SESSION));
// echo md5(uniqid());
//var_dump(password_hash(1608,PASSWORD_DEFAULT));
//var_dump(date('d-m-Y H:i:s'));
//echo (time()+60)."-----".time();
var_dump($_SESSION);