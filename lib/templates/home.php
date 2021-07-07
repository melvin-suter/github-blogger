<?php
foreach(Post::getNewestPosts() as $post){
    echo "<div><a href=\"".Common::url($post['slug'])."\">".$post['title']."</a></div>";
}?>