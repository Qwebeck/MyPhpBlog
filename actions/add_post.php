<?php
    
    function parse_string($pattern,$string){
        
        $arr = explode ( $pattern , $string );
        return join("",$arr);
    }
    $req_username = $_POST['username'];
    $req_password = md5($_POST['passwd']);
    $blogs = scandir('../user_blogs');
    $user_blog;
    $blog_found = FALSE;
    $i=2;
    while(!$blog_find && $i<sizeof($blogs)){
        $user_info = fopen('../user_blogs/'.$blogs[$i].'/info','r');
        $username = fgets($user_info);
        $username = str_replace(PHP_EOL, '', $username);
        $password = fgets($user_info);
        
        $password = str_replace(PHP_EOL, '', $password);
        if(strcmp($username,$req_username)==0 && strcmp($password,$req_password)==0){
        $blog_found = TRUE;
        $blog_dir = '../user_blogs/'.$blogs[$i].'/';
        }  
        fclose($user_info);
        ++$i;
    }
    if($blog_found){
        
        $time_prefix = parse_string('-',$_POST['current_date']).parse_string(':',$_POST['current_time']);
        $post_id = uniqid($time_prefix.date('s'));
        $post_dir = $blog_dir.$post_id;
        mkdir($post_dir,0777);
        $post_dir = $post_dir.'/';
        $post_content = fopen($post_dir.$post_id.'.html','w');
        for($i = 1;$i<3;++$i){
            $info = pathinfo($_FILES['att'.$i]['name']);
            $ext = '.'.$info['extension']; 
            $newname = $time_prefix.$i.$ext; 
            $target = $post_dir.$newname;
            move_uploaded_file( $_FILES['att'.$i]['tmp_name'], $target);
        }
        
        
        $template = "
        <div class='post'>
        <h2>".$_POST['post_title']."</h2>
        <p>".$_POST['description']."</p>
        <form action='actions/add_comment.php'>
        <input name='post_dir' type='hidden' value='".$post_dir."'>
        <input type='submit' value='Add comment'>
        <div class='comment_section'>
        <?php echo 'It is a comment section'; ?>
        </div>
        </form>
        </div>";
        // fwrite($post_content,$_POST['post_title'].PHP_EOL);
        fwrite($post_content,$template);
        fclose($post_content);

        
        header("Location: ../main_page.html?success=true");
    }
    else{
        header("Location: ../main_page.html?success=false");

    }


    
?>