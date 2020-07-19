<?php

require_once 'core/init.php';


$v = Database::instance();
$v->get('usuarios',array('username','=','danilo'));
var_dump($v->count());
