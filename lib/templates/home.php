<html>
    <head>
        <title><?=$entry['title'];?></title>
        <?php include(__DIR__.'/sub/head.php');?>
    </head>
    <body>
        <div class="container">
            <?php include(__DIR__.'/sub/navbar.php');?>
            
            
            <div class="card bg-light">
                <div class="card-body">
                    <?=$entry['body'];?>

                    <?php
                    foreach(Post::getNewestPosts() as $post){
                        echo "<div><a href=\"".Common::url($post['slug'])."\">".$post['title']."</a></div>";
                    }?>
                </div>
            </div>  

            <?php include(__DIR__.'/sub/foot.php');?>
        </div>
    </body>
</html>