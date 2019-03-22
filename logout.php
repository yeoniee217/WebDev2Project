<?php
    session_start();

    session_unset();   // unset $_SESSION variable for the run-time 
    $_SESSION = [];
    
    header("Location: index.php");
    exit;
    // session_destroy($_SESSION['login_user']);   // destroy session data in storage
?>