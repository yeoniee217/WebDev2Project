<?php
    session_start();

    session_unset($_SESSION['login_user']);     // unset $_SESSION variable for the run-time 
    $_SESSION = [];
    // session_destroy($_SESSION['login_user']);   // destroy session data in storage
?>