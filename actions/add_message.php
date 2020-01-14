<?php
    include("semaphore.php");
    // Stop adding files if file size is larger than allowed size
    $allowed_filesize = 200;
    $data = json_decode(file_get_contents('php://input'), true);
    $filename = '../data/messages.txt';
    $size = filesize ($filename);
    if($size > $allowed_filesize) exit(json_encode(["Max number of messages reached"]));
    sem_acquire($semaphore);
    $message = $data['name'].': '.$data['message'].PHP_EOL;     
    file_put_contents($filename, $message, FILE_APPEND);
    sem_release($semaphore);

?>