<?php
    include("semaphore.php");
    
        sem_acquire($semaphore);
        if(!is_dir($_GET['post_dir'].'k')) mkdir($_GET['post_dir'].'k');
        if(!empty($_GET['comment'])){
        $size = sizeof(scandir($_GET['post_dir'].'k')); 
        $comment = fopen($_GET['post_dir'].'k/'.($size-2).'.html','w');
        $content = "<div class='comment'><h3>".$_GET['username']."</h3><h4>".date('Y-m-d H:i')."</h4><h4><h4>".$_GET['mood']."</h4><p>".$_GET['comment']."</p></div>";
        fwrite($comment,$content);
        fclose($comment);
        }
        header("Location: ../blog.php?blog='".$_GET['blog_dir']."'");
    
        sem_release($semaphore);
    

?>