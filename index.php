<?php
    session_start();


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
            <?php if (!isset($_SESSION['login_user'])) : ?>
            <li><a href="login.php">Sign in</a></li>
            <?php else: ?>
            <li><a href="myAccount.php"><?= $_SESSION['login_user'] ?></a></li>
            <?php endif?>
            <li><a href="admin.php">Administration</a></li>
        </ul>
    </nav>

    <div id="content">
        <div id="images">
            <div class="homeImage">
                <img src="images/2.jpg" alt="poodle" style="width:100%; height:450px;">
            </div>
            <div class="homeImage">
                <img src="images/1.jpg" alt="dogandchild" style="width:100%; height:450px;">
            </div>
            <div class="homeImage">
                <img src="images/3.jpg" alt="dog" style="width:100%; height:450px;"> 
            </div>
        </div>

        <div class="details1">
            <h2 class="fontCarter">The best Dog Salon in Winnipeg</h2>
            <p>Paw Pet Spa makes your dogs look and feel great!<br/>
                Our stylists will work with you to accomplish the ideal style for your dogs.</p>
        </div>
        <div class="details1">
            <h2 class="fontCarter">Our services</h2>
            <p>We offer all dog grooming services including a deep claeansing shampoo,<br/>
                conditioning treatment, blow dry, brushing, nail clipping and ear cleaning!<br/>
                If there is a specific style you are looking for we are happy to make your dreams come true!
            </p>
        </div>
        <div class="details2">
            <h2 class="fontCarter">Schedule an appointment</h2>
            <p>To schedule an appointment, click the "Appointment" tap at the top and just fill in the appointment form!<br/>
                Upon submitting the appointment form, we will contact you to confirm within 24 hours.<br/>
                Our appointments generally take 2-3 hours. We will call you 30 minutes before your appointment :) </p>
        </div>
    </div> <!-- end of content div -->


    </body>
</html>