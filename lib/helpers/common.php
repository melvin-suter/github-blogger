<?php

class Common {
    public static function get($key, $default = false){
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }

    public static function url($url){
        if(preg_match("/http(s*):\/\/.*/",$url))
            return $url;
            
        return CONFIG_BASE_URL.$url;
    }

    public static function getEnv($key, $default = ""){
        return isset($_ENV[$key]) ? $_ENV[$key] : $default;
    }
}