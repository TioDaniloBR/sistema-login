<?php

class Sessao
{
    public static function existe($nome)
    {
        return (isset($_SESSION[$nome])) ? true : false;
    }

    public static function put($nome, $valor)
    {
        return $_SESSION[$nome] = $valor;
    }

    public static function get($nome){
        return $_SESSION[$nome];
    }

    public static function delete($nome)
    {
        if(self::existe($nome))
        {
            unset($_SESSION[$nome]);
        }
    }

    public static function flash($nome, $str = '')
    {
        if(self::existe($nome))
        {
            $sessao = self::get($nome);
            self::delete($nome);
            return $session;
        }else{
            self::put($nome ,$str);
        }
    }
}