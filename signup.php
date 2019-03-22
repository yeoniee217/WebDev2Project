<?php
    require_once "connect.php";

    // $username = $password = $repeatPw = "";
    $username_error = $password_error = $repeatPw_error = $firstName_error 
    = $lastName_error = $email_error = $phone_error =  "";

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $repeatPw = filter_input(INPUT_POST, 'repeatPw', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_NUMBER_INT);

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        
        if(empty(trim($username))) {
            $username_error = "Please enter a username.";
        } else {
            $query = "SELECT * FROM users WHERE username = :username";
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $username, PDO::PARAM_STR);
            $statement->execute();
            $user= $statement->fetch();
            $count = $statement->rowCount();

            if($count == 1) {
                $username_error = "The username entered is already existed.";
            }
        }

        if(empty(trim($password))) {
            $password_error = "Please enter a password.";
        } elseif(strlen(trim($password)) < 7) {
            $password_error = "Password must be at least 8 characters.";
        }

        if(empty(trim($repeatPw))) {
            $repeatPw_error = "Please confirm password.";
        } elseif(empty($repeatPw_error) && ($password !== $repeatPw)) {
            $repeatPw_error = "Passwords entered did not match.";
        }
        
        if(empty(trim($firstName))) {
            $firstName_error = "Please enter a first name.";
        } elseif(is_numeric(trim($firstName))) {
            $firstName_error = "Please enter a valid first name.";
        }

        if(empty(trim($lastName))) {
            $lastName_error = "Please enter a last name.";
        } elseif(is_numeric(trim($firstName))) {
            $lastName_error = "Please enter a valid last name.";
        }

        if(!$email) {
            $email_error = "Please enter a valid email.";
        } elseif(empty(trim($email))) {
            $email_error = "Please enter an email.";
        }

        if(empty(trim($phone))) {
            $phone_error = "Please enter a phone number.";
        }

        $valid = empty($username_error) && empty($password_error) && empty($repeatPw_error) && empty($firstName_error) && 
                    empty($lastName_error) && empty($email_error) && empty($phone_error);
        if($valid) {
            $query = "INSERT INTO users (username, password, firstName, lastName, phoneNumber, email) 
                        values (:username, :password, :firstName, :lastName, :phoneNumber, :email)";
            $statement = $db->prepare($query);

            $statement->bindValue(':username', $username, PDO::PARAM_STR);
            $statement->bindValue(':password', $password, PDO::PARAM_STR);
            $statement->bindValue(':firstName', $firstName, PDO::PARAM_STR);
            $statement->bindValue(':lastName', $lastName, PDO::PARAM_STR);
            $statement->bindValue(':phoneNumber', $phone);
            $statement->bindValue(':email', $email);
            $statement->execute();
            
            header("Location: login.php");
            exit;
        }

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
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" type="text/css" href="style.css">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
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

        <div class="card bg-light">
            <article class="card-body mx-auto" style="width: 450px;">
                <h4 class="card-title mt-3 text-center">Create Account</h4>
                <p class="text-center">Get started with your free account</p>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <input name="username" class="form-control col-11" placeholder="User name" type="text" value="<?=$username ?>">
                    </div> <!-- form-group// -->
                    <p class="invalid"><?php echo $username_error; ?></p>

                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input class="form-control" name="password" placeholder="Create password" type="password" value="<?=$password?>">
                    </div> <!-- form-group// -->
                    <p class="invalid"><?php echo $password_error; ?></p>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input class="form-control" name="repeatPw" placeholder="Repeat password" type="password" value="<?=$repeatPw?>">
                    </div> <!-- form-group// --> 
                    <p class="invalid"><?php echo $repeatPw_error; ?></p>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <input name="firstName" class="form-control" placeholder="First name" type="text" value="<?=$firstName?>">
                    </div> <!-- form-group// -->
                    <p class="invalid"><?php echo $firstName_error; ?></p>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <input name="lastName" class="form-control" placeholder="Last name" type="text" value="<?=$lastName?>">
                    </div> <!-- form-group// -->
                    <p class="invalid"><?php echo $lastName_error; ?></p>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        <input name="email" class="form-control" placeholder="Email address" type="email" value="<?=$email?>">
                    </div> <!-- form-group// -->
                    <p class="invalid"><?php echo $email_error; ?></p>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
                        </div>
                        <input name="phone" class="form-control" placeholder="Phone number" type="text" value="<?=$phone?>">
                    </div> <!-- form-group// -->
                    <p class="invalid"><?php echo $phone_error; ?></p>

                    <div class="form-group">
                        <button type="submit" name="create" class="btn btn-primary btn-block"> Create Account  </button>
                    </div> <!-- form-group// -->      
                    <p class="text-center">Have an account? <a href="login.php">Log In</a> </p>                                                                 
                </form>
            </article>
        </div> <!-- card.// -->


    </body>
</html>