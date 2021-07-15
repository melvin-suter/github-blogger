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
            </div>  

            <?php include(__DIR__.'/sub/foot.php');?>
        </div>
    </body>
</html>