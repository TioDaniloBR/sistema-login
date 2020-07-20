<?php
class Criptografia
{
    public static function criar($str, $salt = '')
    {
        return hash('md5',$str.$salt);
    }

    public static function salt($valor)
    {
        return password_hash($valor,PASSWORD_DEFAULT);
    }
}