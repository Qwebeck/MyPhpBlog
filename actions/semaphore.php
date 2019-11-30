<?php
$key = 156789;
$max = 1;
$permission = 0777;
$auto_release = 1;

$semaphore = sem_get($key,$max,$permission,$auto_release);
if(!$semaphore) {
    echo "Failed on sem_get().\n";
    header("Location: ../main_page.html?success=false");
}
?>