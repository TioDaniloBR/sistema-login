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

 $var = new Usuario('gothic.joker');