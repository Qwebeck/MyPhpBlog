<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog</title>
    <link rel="stylesheet" media="screen" href="style/mainLayout.css"/>
    <link rel="stylesheet" media="screen" href="style/blogLayout.css"/>
</head>
<body>
<?php  $menu = file_get_contents("menu_bar.html");
        echo $menu;?>
<div class="content">
<?php

    function generate_comments($target_post_dir){
        $comment_section;
        $i = 1;
        if(is_dir($target_post_dir.'k')){
        while($new = file_get_contents($target_post_dir.'k/'.$i.".html")){
           $comment_section.=$new;
           ++$i;
        }
        }
        return $comment_section;
    }


    if(isset($_GET['success']) && strcmp($_GET['success'],"true")==0) echo file_get_contents("success.html");
    elseif(isset($_GET['success']) && strcmp($_GET['success'],"false")==0) echo file_get_contents("fail.html");


    if(isset($_GET['blog']) && !empty($_GET['blog'])){
        $blog_name = str_replace("'", "", $_GET['blog']);
        $blog_location ='user_blogs/'.$blog_name;
        if(is_dir($blog_location)){
            echo "<h1>".$blog_name."</h1>";
            $posts = scandir($blog_location);
            for($i = 2;$i < sizeof($posts);++$i){
                if(!strcmp($posts[$i],"info")){}
                else include($blog_location.'/'.$posts[$i].'/'.$posts[$i].'.html');
                echo "<div class='comment_section'>"
                .generate_comments($blog_location.'/'.$posts[$i].'/')."</div>";
            }
        } else {
            echo "No blog exist";
        }
    }else{
        
        $blog_location ='user_blogs/';
        if(is_dir($blog_location)){
            echo "<h1>All blogs</h1>";
            $posts = scandir($blog_location);
            for($i = 2;$i < sizeof($posts);++$i){
                
                echo "<a href='blog.php?blog=".$posts[$i]."'> 
                <div class='post'><h2>".$posts[$i]."</h2>
                </div></a>";

    }
}
    }
?>
</div>

</body>
</html>
