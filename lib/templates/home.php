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
            </div>  

            <?php
                foreach(Post::getPostsFrom(Common::get('page',0),10) as $post){
                    ?>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><a href="<?=Common::url($post['slug']);?>"><?=$post['title'];?></a></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?=date('Y/m/d H:M:i',$post['timestamp']);?></h6>
                                <p class="card-text"></p>
                            </div>
                        </div>
                    <?php
                    echo "<div><a href=\"".Common::url($post['slug'])."\">".$post['title']."</a></div>";
                }?>
            </div>

            <?php include(__DIR__.'/sub/foot.php');?>
        </div>
    </body>
</html>