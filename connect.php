<?php
/*****************************************
 *
 *  Purpose: The php file for connecting to the database
 *  Author: Jihyeon Lee
 *  Date Created: March 14, 2019
 *
 *****************************************/

    define('DB_DSN','mysql:host=localhost;dbname=serverside');
    define('DB_USER','serveruser');
    define('DB_PASS','gorgonzola7!');     
    
    try {
        //Create a PDO object called $db
        $db = new PDO(DB_DSN, DB_USER, DB_PASS);
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage();
        die(); // Force execution to stop on errors.
    }
?>