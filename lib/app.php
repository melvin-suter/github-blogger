<?php

require_once(__DIR__.'/helpers/paths.php');
require_once(__DIR__.'/helpers/common.php');
require_once(__DIR__.'/helpers/post.php');
require_once(__DIR__.'/helpers/gitworker.php');

Paths::load();

$action = Common::get('a');

switch($action) {
    case 'post':
        $slug = Common::get('s','404');
        Post::show($slug);
        break;
    default:
        break;    
}