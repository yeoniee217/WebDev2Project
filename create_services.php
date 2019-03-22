<?php
/*****************************************
 *
 *  Purpose: The php file for the blog home page
 *  Author: Jihyeon Lee
 *  Date Created: March 14, 2019
 *
 *****************************************/
session_start();
require 'connect.php';

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Paw Pet Spa</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Carter+One" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="style.css">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </head>
    <body>

    <div class="header">
        <h1 class="headerFont"><a href="index.php">the Paw Pet Spa</a></h1>
    </div>

    <nav class="topNav">
        <ul class="center">
            <li><a href="index.php">Home</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="#">Appointment</a></li>
            <?php if (!isset($_SESSION['loggedin'])) : ?>
            <li><a href="login.php">Sign in</a></li>
            <?php else: ?>
            <li><a href="myAccount.php?id=<?= $_SESSION['id']?>"><?= $_SESSION['username'] ?></a></li>
            <li><a href="logout.php">Sign out</a></li>
            <?php endif?>
            <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['id'] == 2):?>
            <li><a href="admin.php">Administration</a></li>
            <?php endif?>
        </ul>
    </nav>

    <div class="all_services">
        <form action="process_post.php" method="post" role="form">
            <fieldset>
                <legend>New Service</legend>
                <div class="form-group">
                    <div class="col-xs-4">
                        <label for="name">Service Name</label>
                        <input class="form-control" name="name" id="name" name="name">
                    </div>
                </div>

                <div class="input-group mb-3">
                    <div class="col-xs-3">
                        <label for="cost">Service Cost</label>                       
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                            <input name="cost" id="cost" type="text" class="form-control" >
                        </div>
                        </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control summernote" rows="10" name="description" id="description"></textarea>
                </div>

                <div><input name="create" class="btn btn-primary" type="submit" value="Create Service"></div>
            </fieldset>
        </form>
    </div> <!-- div.container -->

    </body>
</html>