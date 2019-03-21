<?php
//*****************************************
// *
// *  Purpose: The php file for the user authentication
// *  Author: Jihyeon Lee
// *  Date Created: March 14, 2019
// *
// *****************************************/
  define('ADMIN_LOGIN','jl');

  define('ADMIN_PASSWORD','mypass');

  if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])

      || ($_SERVER['PHP_AUTH_USER'] != ADMIN_LOGIN)

      || ($_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD)) {

    header('HTTP/1.1 401 Unauthorized');

    header('WWW-Authenticate: Basic realm="Our Blog"');

    exit("Access Denied: Username and password required.");

  }

   

?>