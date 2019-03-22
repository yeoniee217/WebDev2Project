<?php 
    session_start();
    
    if(isset($_SESSION['loggedin'])) {
        header("Location: index.php");
        exit;
    }

    require_once "connect.php";

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $username_error = $password_error = $error =  "";

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        if(empty(trim($username))) {
            $username_error = "Please enter your username.";
        }

        if(empty(trim($password))) {
            $password_error = "Please enter your password.";
        }

        if(empty($username_error) && empty($password_error)) {
            $query = "SELECT * FROM users WHERE username = :username AND password = :password";
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $username, PDO::PARAM_STR);
            $statement->bindValue(':password', $password, PDO::PARAM_STR);

            $statement->execute();
            $user= $statement->fetch();

            if($username == $user['username'] && $password == $user['password']) {
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                header("Location: index.php");
                exit;
            } else {
                $error = "Username or password is invalid. Please try it again.";
            }
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
        
        <div class="wrapper bg-light">
            <h2 class="form-group col-md-7 font-weight-bold">Sign in</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group col-md-11 font-weight-bold">
                    <label for="uname">Username</label>
                    <input type="text" class="form-control" id="uname" placeholder="Enter your username" name="username" value="<?=$username?>">
                </div>
                <p class="invalid"><?=$username_error?></p>

                <div class="form-group col-md-11 font-weight-bold">
                    <label for="pwd">Password</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter your password" name="password">
                </div>
                <p class="invalid"><?=$password_error?></p>

                <p class="error"><?=$error?></p>
                <div class="form-group col-md-11 marginTop">
                    <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                    <div class="marginTop1"><a href="signup.php" class="btn btn-outline-dark btn-block">Create account</a></div>
                </div>
            </form>
        </div>
  
    </body>
</html>