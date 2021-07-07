<div class="text-center">

    <h1 class="display-1"><?=CONFIG_PAGE_TITLE;?></h1>
    <h1 class="lead"><?=CONFIG_PAGE_DESCRIPTION;?></h1>
</div>

    <ul class="nav justify-content-center mt-3 mb-5">
        <?php
        foreach(Post::getMenuPages() as $k => $menuEntry){
            ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?=Common::url('/'.$menuEntry['slug']);?>"><?=$menuEntry['menu'];?></a>
                </li>
            <?php
        }
        ?>
    </ul>

