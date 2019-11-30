<?php
    include("semaphore.php");
    function parse_string($pattern,$string){
        
        $arr = explode ( $pattern , $string );
        return join("",$arr);
    }

    
    
    $blog_name;
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
        $blog_name = $blogs[$i];
        $blog_dir = '../user_blogs/'.$blog_name.'/';
        }  
        fclose($user_info);
        ++$i;
    }
    // Applying sempahore in critical zone
    
    if($blog_found){
        
            sem_acquire($semaphore);
    
            $time_prefix = parse_string('-',$_POST['current_date']).parse_string(':',$_POST['current_time']);
            $post_id = uniqid($time_prefix.date('s'));
            $post_dir = $blog_dir.$post_id;
            mkdir($post_dir,0777);
            $post_dir = $post_dir.'/';
            $attachments ="<div class='attachments'> <h4> Blog attachments:</h4>";
            $att_number = 0;
            for($a = 0;$a <= 3;++$a){
                // if(!isset($_FILES["att".$a])) continue;
                $path = $_FILES["att".$a]['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $target_file = $post_dir.$time_prefix.$a.'.'.$ext;
            if (move_uploaded_file($_FILES["att".$a]["tmp_name"], $target_file)) {
                $attachments.="<a href='user_blogs/".$blog_name.'/'.$post_id.'/'.$time_prefix.$a.'.'.$ext."'> Attachment ".$a."</a>";
                $att_number += 1;
            } else {
            }
            }
            $attachments .="</div>";
            if($att_number==0) $attachments = "";

            $post_content = fopen($post_dir.$post_id.'.html','w');
            $template = "
            <div class='post'>
            <h2>".$_POST['post_title']."</h2>
            <p>".$_POST['description']."</p>"
            .$attachments.
            "<form action='actions/add_comment.php'>
            ".file_get_contents("../add_comment.html").
            "<input name='post_dir' type='hidden' value='".$post_dir."'/>
            <input name='blog_dir' type='hidden' value='".$blog_name."'/>
            </form>
            </div>";
            fwrite($post_content,$template);
            fclose($post_content);
            header("Location: ../blog.php?success=true");
            sem_release($semaphore);
        
    }
    else{
        header("Location: ../blog.php?success=false");

    }


    
?>