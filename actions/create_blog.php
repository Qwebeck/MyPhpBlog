<?php
 include("semaphore.php");
 $dirname = '../user_blogs/'.$_POST['blog_name'];
 $username = $_POST['username'];
 $passwd = md5($_POST['passwd']);
 $descr = $_POST['description'];
   sem_acquire($semaphore);
   if(!is_dir($dirname)){
      mkdir($dirname,0777);
      $info = fopen($dirname.'/info','w');
      fwrite($info,$username.PHP_EOL);
      fwrite($info,$passwd.PHP_EOL);
      fwrite($info,$descr.PHP_EOL);
      fclose($info);
      header("Location: ../blog.php?success=true");
    }else{
      header("Location: ../blog.phpl?success=day");
    
    sem_release($semaphore);
 }
?>
