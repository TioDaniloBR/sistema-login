<?php
require_once 'core/init.php';

$usuario = new Usuario();

$usuario->logout();

Redirecionar::para('index.php');