<?php
/*****************************************
 *
 *  Purpose: Processes post methods(create, update, delete a post)
 *  Author: Jihyeon Lee
 *  Date Created: March 14, 2019
 *
 *****************************************/
require 'authenticate.php';
require 'connect.php';

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$cost = filter_input(INPUT_POST, 'cost', FILTER_SANITIZE_NUMBER_INT);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

$valid = filter_input(INPUT_POST, 'cost', FILTER_VALIDATE_INT) && !empty(trim($name)) && !empty(trim($description));

if(isset($_POST['create'])) {

    if($valid) {
            //Build the parameterized SQL query and bind to the above sanitized values.
            $query = "INSERT INTO services (name, cost, description) values (:name, :cost, :description)";
            $statement = $db->prepare($query);

            $statement->bindValue(':name', $name);
            $statement->bindValue(':cost', $cost);
            $statement->bindValue(':description', $description);
            $statement->execute();  //Execute the INSERT

            header("Location: admin.php");
            exit;

        } else {
            $error = "An error occured while processing your submission.";
        }
}

//$_POST['update'] : this represents "submit type" input tag named 'update'(in html section(in edit.php file))
//if user clicked that submit type input tag named 'update'...do this.
if (isset($_POST['update']) ) 
{    
    if($valid) {

        $query = "UPDATE services SET name = :name, cost = :cost, description = :description WHERE id = :id";
        $statement = $db->prepare($query);

        $statement->bindValue(':name', $name);
        $statement->bindValue(':cost', $cost);      
        $statement->bindValue(':description', $description);
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
    $query = "DELETE FROM services WHERE id = :id";

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
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
            <li><a href="login.php">Sign in</a></li>
            <li><a href="admin.php">Administration</a></li>
        </ul>
    </nav>

    <div><span class="error"><?=$error ?></span></div>

    </body>
</html>