<?php

class Redirecionar
{
    public static function para($local = null)
    {
        if($local)
        {
            if(is_numeric($local))
            {
                switch($local)
                {
                    case '404':
                        header('HTTP/1.0 404 Not Found');
                        include 'includes/error/404.php';
                        exit();
                    break;
                }
            }
            header('Location: '.$local);
            exit();
        }
    }
}