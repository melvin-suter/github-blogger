<?php

class Post {

    private static function checkCache($slug){
        $data = json_decode(file_get_contents(cacheDBPath),true);
        $res = false;

        if(array_key_exists($slug,$data))
        {
            $diff = (new DateTime)->diff(DateTime::createFromFormat("u",$data[$slug]['timestamp']));
            
            if($diff->s <= 3600 && Common::get('clear-cache',0) == 0){
                $res = $data[$slug];
            } else {
                $res = false;
                unlink(cacheDir."/".$data[$slug]['id']);
                unset($data[$slug]);
                file_put_contents(cacheDBPath,json_encode($data));
            }
        }
        
        return $res;
    }

    private static function generateCache($slug){
        $data = json_decode(file_get_contents(cacheDBPath),true);
        $file = self::findFileToSlug($slug);
        $meta = self::getMetaData($file);

        $cacheEntry = ['id' => uniqid('temp_'),'timestamp' => (new DateTime())->format("u")];

        $Parsedown = new Parsedown();

        $entry['body'] = $Parsedown->text(file_get_contents($file));
        $entry['title'] = $meta['title'];

        ob_start();
        include(templateDir.'/'.$meta['layout'].'.php');
        $output = ob_get_clean();
        file_put_contents(cacheDir."/".$cacheEntry['id'],$output);

        $data[$slug] = $cacheEntry;
        file_put_contents(cacheDBPath,json_encode($data));
        return $cacheEntry;
    }

    public static function show($slug){
        $cacheEntry = self::checkCache($slug);
        if($cacheEntry == false){
            $cacheEntry = self::generateCache($slug);
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
            if($meta['slug'] = $slug)
                $fileHit = $file;
        }

        return $fileHit;
    }
}