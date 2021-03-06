<html>
    <head>
        <title><?=$entry['title'];?></title>
        <?php include(__DIR__.'/sub/head.php');?>
    </head>
    <body>
        <div class="container">
            <?php include(__DIR__.'/sub/navbar.php');?>
            
            
            <div class="card bg-light mb-5">
                <div class="card-body">
                    <?=$entry['body'];?>
                </div>  
            </div>

            <?php
                foreach(Post::getPostsFrom(Common::get('page',0),10) as $post){
                    ?>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><a href="<?=Common::url($post['slug']);?>"><?=$post['title'];?></a></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?=date('Y/m/d H:i',$post['timestamp']);?></h6>
                                <p class="card-text"><?=$post['lead'];?></p>
                            </div>
                        </div>

                    <?php
                }


                        if(Post::getNumberOfPages(10) > 1){
                            ?>
                                <div class="mt-5 w-100 d-flex justify-content-center">
                                    <ul class="pagination">
                                        <?php
                                            if(Common::get('page',1) > 1){
                                                echo '<li class="page-item"><a class="page-link" href="?page='.(Common::get('page',1) - 1).'">Previous</a></li>';
                                            }else{
                                                echo '<li class="page-item"><a class="page-link">Previous</a></li>';
                                            }

                                            for($i = 1 ; $i <= Post::getNumberOfPages(10); $i++){
                                                echo '<li class="page-item"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
                                            }

                                        

                                        if(Common::get('page',1) < Post::getNumberOfPages(10)){
                                            echo '<li class="page-item"><a class="page-link" href="?page='.(Common::get('page',1) + 1).'">Next</a></li>';
                                        } else {
                                            echo '<li class="page-item"><a class="page-link">Next</a></li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            <?php
                        }
                    ?>

            <?php include(__DIR__.'/sub/foot.php');?>
        </div>
    </body>
</html>