<?php
//a classe config será usada para acessar array global de configurações pré definidas no init.php

class Config{
    public static function get($caminho = null){
        if($caminho)
        {
            $config = $GLOBALS['config'];
            $caminho = explode(',',$caminho);
            
            foreach($caminho as $cam)
            {
                if(isset($config[$cam]))
                {
                    $config = $config[$cam];
                }
            }
            return $config;
        }
        return false;
    }
}