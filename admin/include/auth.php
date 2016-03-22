<?php

session_start();
$login = false;
if(isset($_SESSION['logged'])) {
    
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
        
    $user = $db
        ->where('user', $user_name)
        ->where('id', $user_id)
        ->getOne('admin');
    
    if(!empty($user)) {
        $login = true;
    } 
}
if(basename($_SERVER['PHP_SELF']) == "login.php") {
    
    if($login == true) {
        header("Location: index.php");
        exit();
    }
    $hidenav = true;
    
} else {
    
    if($login !== true) {
        header("Location: login.php");
        exit();
    }
}


?>
