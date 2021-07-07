<?php

class Paths {

    public static function load() {
        define("baseDir", realpath(__DIR__.'/../..'));
        define("templateDir", baseDir.'/lib/templates');
        define("publicDir", baseDir.'/public');
        define("contentDir", baseDir.'/content');
        define("cacheDir", baseDir.'/cache');
        define("cacheDBPath", cacheDir.'/db.json');
        
    }
}
