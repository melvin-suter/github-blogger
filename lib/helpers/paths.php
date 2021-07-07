<?php

class Paths {

    public static function load() {
        define("baseDir", realpath(__DIR__.'/../..'));
        define("templateDir", realpath(baseDir.'/lib/templates'));
        define("publicDir", realpath(baseDir.'/public'));
        define("contentDir", realpath(baseDir.'/content'));
        define("cacheDir", realpath(baseDir.'/cache'));
        define("cacheDBPath", realpath(cacheDir.'/db.json'));
        
       ;
    }
}
