<?php
/*****************************************
 *
 *  Purpose: The php file for the blog home page
 *  Author: Jihyeon Lee
 *  Date Created: March 14, 2019
 *
 *****************************************/
session_start();
require 'authenticate.php';
require 'connect.php';

$query = "SELECT * FROM services ORDER BY id DESC";
$statement = $db->prepare($query); //Returns a PDOStatement object.
$statement->execute();        // The query is now executed.
$services = $statement->fetchAll();  //fetchAll: get an array of all the rows

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

        <?php if($services != null): ?>
        <div class="all_services marginTop">
            <h3>Services</h3>

            <?php foreach($services as $service): ?>
            <div class="service">
                <ul>
                    <li>
                        <h5><a href="show_service.php?id=<?= $service['id'] ?>"><?= $service['name'] ?></a> (Cost: $<?= $service['cost'] ?>)</h5>
                        <div class="service_description">
                            <?php if(strlen($service['description']) > 60): ?>
                                <?php $contentPreview = substr($service['description'], 0, 60); ?>
                                <?= $contentPreview ?> <?= '...'; ?>
                                <small><a href="show_service.php?id=<?= $service['id'] ?>">Read more</a></small>
                            <?php else: ?>
                                <?= $service['description'] ?>
                            <?php endif ?>
                        </div>
                    </li>
                </ul>
            </div>
            <?php endforeach ?>
        </div> <!-- END div id=all_services -->

        <?php else: ?>
            <p>No services found</p>
        <?php endif; ?>

        <p class="addLink"><a href="create_services.php" class="btn btn-primary">Add Service</a></p>
    </body>
</html>