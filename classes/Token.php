<?php

class Token
{
    public static function gerarToken(){
        return Sessao::put(Config::get('sessao,nomeToken'),md5(uniqid()));
    }

    public static function checarToken($token)
    {
        $nomeToken = Config::get('sessao,nomeToken');
        if(Sessao::existe($nomeToken) && $token === Sessao::get($nomeToken))
        {
            Sessao::delete($nomeToken);
            return true;
        }else{
            return false;
        }
    }
}