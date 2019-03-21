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
        
        <div class="wrapper bg-light">
            <h2 class="form-group col-md-7 font-weight-bold">Sign in</h2>
            <form action="/action_page.php" class="was-validated">
                <div class="form-group col-md-11 font-weight-bold">
                    <label for="uname">Username</label>
                    <input type="text" class="form-control" id="uname" placeholder="Enter your username" name="uname" required>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="form-group col-md-11 font-weight-bold">
                    <label for="pwd">Password</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter your password" name="pswd" required>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                
                <div class="form-group col-md-11 marginTop">
                    <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                    <div class="marginTop1"><a href="signup.php" class="btn btn-outline-dark btn-block">Create account</a></div>
                </div>
            </form>
        </div>
  
    </body>
</html>