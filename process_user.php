<?php
/*****************************************
 *
 *  Purpose: Processes post methods(create, update, delete a post)
 *  Author: Jihyeon Lee
 *  Date Created: March 14, 2019
 *
 *****************************************/
session_start();
require 'authenticate.php';
require 'connect.php';

$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$phoneNumber = filter_input(INPUT_POST, 'phoneNumber', FILTER_SANITIZE_NUMBER_INT);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

$valid = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT) && !empty(trim($firstName)) && !empty(trim($lastName)) && !empty(trim($phoneNumber)) && !empty(trim($email)) ;

//$_POST['update'] : this represents "submit type" input tag named 'update'(in html section(in edit.php file))
//if user clicked that submit type input tag named 'update'...do this.
if (isset($_POST['update']) ) 
{    
    if($valid) {

        $query = "UPDATE users SET firstName = :firstName, lastName = :lastName, phoneNumber = :phoneNumber, email = :email WHERE id = :id";
        $statement = $db->prepare($query);

        $statement->bindValue(':firstName', $firstName);
        $statement->bindValue(':lastName', $lastName);      
        $statement->bindValue(':phoneNumber', $phoneNumber);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        header("Location: admin.php");
        exit;
    } else{
        $error = "An error occured while processing your post.";
    } 
}

//$_POST['delete'] : this represents "submit type" input tag named 'delete'(in html section(in edit.php file))
if(isset($_POST['delete']))
{
    $query = "DELETE FROM users WHERE id = :id";

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    header("Location: admin.php");
    exit;    
}

$getid = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if(isset($_GET['id']))
{
    $query = "DELETE FROM users WHERE id = :id";

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $getid, PDO::PARAM_INT);
    $statement->execute();

    header("Location: admin.php");
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

    <div><span class="error"><?=$error ?></span></div>

    </body>
</html>