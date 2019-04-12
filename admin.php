<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Paw Pet Spa</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Carter+One" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="style.css">

        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>

        <link href="css/addons/datatables.min.css" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
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

        <div>
            <ul class="item">
                <li><a href="manageService.php">Manage Services</a></li>
                <li><a href="manageUser.php">Manage Users</a></li>
            </ul>
        </div>
    
    </body>
</html>