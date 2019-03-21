<?php
/*****************************************
 *
 *  Purpose: The php file for the 'full post' page
 *  Author: Jihyeon Lee
 *  Date Created: January 28, 2019
 *
 *****************************************/
    require 'connect.php';

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if($id) {
        $cleanId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        
        $query = "SELECT * FROM services WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $cleanId, PDO::PARAM_INT );
        $statement->execute();
        $service = $statement->fetch(); 

        if (is_null($service['id']))
        {
            header("Location: index.php");
        }

    } else {
        header("Location: index.php");
        exit;
    }

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
            <li><a href="login.php">Sign in</a></li>
            <li><a href="admin.php">Administration</a></li>
        </ul>
    </nav>

    <div class="all_services addLink">
        <div class="service">
            <h3><?= $service['name'] ?> (Cost: $<?= $service['cost']?>)</h3>
            <div class='blog_content'>
                <?= $service['description'] ?>     
            </div>
            <p class="marginTop2"><a class="btn btn-info" role="button" href="edit_service.php?id=<?= $service['id'] ?>">Edit</a></p>
        </div>     
    </div> <!-- END div id=all_services -->

    </body>
</html>