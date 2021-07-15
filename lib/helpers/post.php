<?php

class Post {

    private static function checkCache($id){
        $data = json_decode(file_get_contents(cacheDBPath),true);
        $res = false;

        if(array_key_exists($id,$data))
        {
            $diff = (new DateTime)->diff(DateTime::createFromFormat("u",$data[$id]['timestamp']));

            if($diff->s <= 3600 && Common::get('clear-cache',0) == 0){
                $res = $data[$id];
            } else {
                $res = false;
                unlink(cacheDir."/".$data[$id]['id']);
                unset($data[$id]);
                file_put_contents(cacheDBPath,json_encode($data));
            }
        }
        
        return $res;
    }

    private static function generateCache($slug,$id){
        $data = json_decode(file_get_contents(cacheDBPath),true);
        $file = self::findFileToSlug($slug);
        if($file == false)
        {
            return false;
        }

        $meta = self::getMetaData($file);

        $cacheEntry = ['id' => uniqid('temp_'),'timestamp' => (new DateTime())->format("u")];

        $Parsedown = new Parsedown();

        $entry['body'] = $Parsedown->text(file_get_contents($file));
        $entry['title'] = $meta['title'];

        ob_start();
        include(templateDir.'/'.$meta['layout'].'.php');
        $output = ob_get_clean();
        file_put_contents(cacheDir."/".$cacheEntry['id'],$output);

        $data[$id] = $cacheEntry;
        file_put_contents(cacheDBPath,json_encode($data));
        return $cacheEntry;
    }

    public static function show($slug){
        if($slug == "home")
            $cacheEntry = self::checkCache($_SERVER["REQUEST_URI"]);
        else
            $cacheEntry = self::checkCache($slug);

        if($cacheEntry == false){
            if($slug == "home")
                $cacheEntry = self::generateCache($slug,$_SERVER["REQUEST_URI"]);
            else
                $cacheEntry = self::generateCache($slug,$slug);
        } 

        if($cacheEntry == false){
            Post::show('404');
            return;
        }

        include(cacheDir."/".$cacheEntry['id']);
    }

    private static function getMetaData($file){
        $meta = [];

        $handle = fopen($file, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if(preg_match("/<!--\s+(.*):\s+(.*)\s+-->/",$line, $re))
                {
                    $meta[$re[1]] = $re[2];
                } else {
                    break;
                }
            }

            fclose($handle);
        }

        return $meta;
    }

    private static function findFileToSlug($slug){
        $files = glob(contentDir.'/*.md');
        $fileHit = false;

        foreach($files as $file){
            $meta = self::getMetaData($file);
            if($meta['slug'] == $slug)
                $fileHit = $file;
        }

        return $fileHit;
    }


    

    public static function getAllPostsSorted(){
        $files = glob(contentDir.'/*.md');
        $entries = [];

        foreach($files as $file){
            $meta = self::getMetaData($file);

            if($meta['layout'] == "page" || $meta['layout'] == "home")
                continue;
            
            $entries[$meta['timestamp']] = $meta;
        }

        ksort($entries);

        return $entries;
    }

    public static function getNumberOfPages($itemsPerPage){
        $entries = self::getAllPostsSorted();

        return ceil(count($entries) / $itemsPerPage);
    }

    public static function getPostsFrom($page,$itemsPerPage){
        $entries = self::getAllPostsSorted();

        $offset = ($page - 1) * $itemsPerPage;

        return array_slice($entries, $offset, $itemsPerPage);
    }

    public static function getMenuPages(){
        $files = glob(contentDir.'/*.md');
        $menuEntires = [];
        $i = 9000;

        foreach($files as $file){
            $meta = self::getMetaData($file);
            if(isset($meta['menu']))
                if(isset($meta['menupos']))
                    $menuEntires[$meta['menupos']] = $meta;
                else
                    $menuEntires[$i] = $meta;
            $i++;
        }
        
        ksort($menuEntires);
        return $menuEntires;
    }

    public static function clearCache(){

        $files = glob(cacheDir.'/temp_*');

        foreach($files as $file){
            unlink($file);
        }
        file_put_contents(cacheDBPath,'[]');

        header("Location: ".Common::url("/"));
        exit;
    }
}