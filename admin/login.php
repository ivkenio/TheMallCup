<?php
require_once('include/main.php');

$data = array();

if(isset($_POST['action'])) {
    if(isset($_POST['username']) && !empty($_POST['username']) 
    && isset($_POST['password']) && !empty($_POST['password'])) {
        
        $user = addslashes($_POST['username']);
        $pass = addslashes($_POST['password']);
        
        $user = $db
            ->where('user', $user)
            ->where('pass', sha1($pass."salut"))
            ->getOne('admin');
        
        if(!empty($user)) {
            $_SESSION['logged'] = 1;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['user'];
            
            header("Location: index.php");
            exit();
        } else {
            $data['error'] = "Грешно потребителско име или парола";
        }
    
    } else {
        $data['error'] = "Грешно потребителско име или парола";
    }
    
}
$data['hidenav'] = true;

loadTemplate("login", $data);

?>
