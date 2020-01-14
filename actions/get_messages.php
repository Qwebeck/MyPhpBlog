<?php
/**
 * Handle GET requests from user
 */
ignore_user_abort(false);

$request_time = (int)$_GET['timestamp'];
$is_first= isset($_GET['first']);
$file = '../data/messages.txt';
$fileModifyTime = filemtime($file);

while (true) {
    $fileModifyTime = filemtime($file);
    if ($fileModifyTime === false) {
        throw new Exception('Could not read last modification time');
    }
     
    if ($fileModifyTime > $request_time || $is_first) {
        setcookie('lastUpdate', $fileModifyTime);
        $fileRead = file_get_contents($file);
        exit(json_encode([
            'content' => $fileRead
        ]));
    }
  
    clearstatcache();
    sleep(1);
}



?>