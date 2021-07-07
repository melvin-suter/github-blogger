<?php

require_once(__DIR__.'/helpers/paths.php');
require_once(__DIR__.'/helpers/common.php');
require_once(__DIR__.'/helpers/post.php');
require_once(__DIR__.'/helpers/gitworker.php');
require_once(__DIR__.'/config.php');

Paths::load();

if(!file_exists(cacheDBPath))
    file_put_contents(cacheDBPath,'[]');

$action = Common::get('a','home');

switch($action) {
    case 'post':
        $slug = Common::get('s','404');
        Post::show($slug);
        break;
    case 'home':
        Post::show('home');
        include(templateDir.'/home.php');
        break;
    default:
        Post::show('404');
        break;    
}