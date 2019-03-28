<?php
/*****************************************
 *
 *  Purpose: The php file for the 'full post' page
 *  Author: Jihyeon Lee
 *  Date Created: January 28, 2019
 *
 *****************************************/
    session_start();
    require 'connect.php';
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $id) 
    {
        $cleanId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        
        $query = "SELECT * FROM users WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $cleanId, PDO::PARAM_INT );
        $statement->execute();
        $user = $statement->fetch(); 

        if (is_null($user['id']))
        {
            header("Location: index.php");
        }

    } 
    else {
        header("Location: index.php");
        exit;
    }

    // function setPhoneNumberFormat($number) {
    //     $result = substr($number, 0, 3) . '-' .substr($number, 3, 3) . '-' . substr($number, 4, 4);
    //     return $result;
    // }

    // if(isset($user['phoneNumber'])) {
    //     $phoneNum = setPhoneNumberFormat($user['phoneNumber']);
    // }

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
        <form action="process_user.php" method="post" role="form">
            <fieldset>
                <legend>Edit account</legend>
                <div class="form-group">
                    <div class="col-xs-4">
                        <label for="name">First Name</label>
                        <input class="form-control" id="name" name="firstName" value="<?=$user['firstName']?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-4">
                        <label for="name">Last Name</label>
                        <input class="form-control" id="name" name="lastName" value="<?=$user['lastName']?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-4">
                        <label for="name">Phone number</label>
                        <input class="form-control" id="name" name="phoneNumber" value="<?=$user['phoneNumber']?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-4">
                        <label for="name">Email</label>
                        <input class="form-control" id="name" name="email" value="<?=$user['email']?>">
                    </div>
                </div>

                <div>
                    <input type="hidden" name="id" value="<?= $user['id'] ?>" />
                    <input type="submit" name="update" class="btn btn-primary" value="Update account">
                    <input type="submit" name="delete" class="btn btn-primary" value="Delete account" onclick="return confirm('Are you sure you wish to delete this service?')" />
                </div>
            </fieldset>
        </form>
    </div> <!-- div.container -->

    </body>
</html>