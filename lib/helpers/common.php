<?php

class Common {
    public static function get($key, $default = false){
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }

    public static function url($url){
        if(preg_match("/http(s*):\/\/.*/",$url))
            return $url;
        
        if(substr(CONFIG_BASE_URL,-1) == "/")
            $newUrl =  CONFIG_BASE_URL;
        else
            $newUrl = CONFIG_BASE_URL."/";
        
        if(substr($url,0,1) == "/")
            $newUrl = $newUrl;
        else
            $newUrl = "/".$newUrl;

        return $newUrl;
    }

    public static function getEnv($key, $default = ""){
        return isset($_ENV[$key]) ? $_ENV[$key] : $default;
    }
}