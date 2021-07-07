<?php

class Common {
    public static function get($key, $default = false){
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }
}