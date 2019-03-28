<?php
/*****************************************
 *
 *  Purpose: The php file for the blog home page
 *  Author: Jihyeon Lee
 *  Date Created: March 14, 2019
 *
 *****************************************/
session_start();
require_once 'authenticate.php';
require 'connect.php';

$query = "SELECT * FROM services ORDER BY name ASC";
$statement = $db->prepare($query); //Returns a PDOStatement object.
$statement->execute();        // The query is now executed.

$services = $statement->fetchAll();  //fetchAll: get an array of all the rows

$query = "SELECT * FROM users ORDER BY id ASC";
$statement = $db->prepare($query); //Returns a PDOStatement object.
$statement->execute();        // The query is now executed.

$users = $statement->fetchAll();  //fetchAll: get an array of all the rows

function setPhoneNumberFormat($number) {
    $result = substr($number, 0, 3) . '-' .substr($number, 3, 3) . '-' . substr($number, 4, 4);
    return $result;
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

        <div class="col-md-12">
            <form action="process_post.php" method="post" id="form-list-client">
                <legend>List of services</legend>
                <div class="pull-right">
                    <a class="btn btn-default-btn-xs btn-success" href="create_services.php"><i class="glyphicon glyphicon-plus"></i> Add Service</a>
                </div>
                <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <td>Service name</td>
                            <th>Cost</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <?php if($services != null): ?>
                    <tbody id="form-list-client-body">
                    <?php foreach($services as $service): ?>
                        <tr>
                            <td><h5><a href="show_service.php?id=<?= $service['id'] ?>"><?= $service['name'] ?></a></h5></td>
                            <td><h5>$<?= $service['cost'] ?></h5></td>                          
                            <td>
                                <a href="show_service.php?id=<?= $service['id'] ?>" title="view this service" class="btn btn-default btn-sm "> <i class="glyphicon glyphicon-eye-open text-primary"></i> </a>
                                <a href="edit_service.php?id=<?= $service['id'] ?>" title="edit this service" class="btn btn-default btn-sm "> <i class="glyphicon glyphicon-edit text-primary"></i> </a>
                                <a href="process_post.php?id=<?=$service['id']?>" title="delete this service" class="btn btn-default btn-sm " onclick="return confirm('Are you sure you wish to delete this service?')"> <i class="glyphicon glyphicon-trash text-danger"></i> </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>

                <?php else: ?>
                    <p>No services found</p>
                <?php endif; ?>
            </form>
        </div>
        <br/>
        <br/>
        <div class="col-md-12">
            <form action="process_post.php" method="post" id="form-list-client">
                <legend>List of users</legend>
                <div class="pull-right">
                    <a class="btn btn-default-btn-xs btn-success" href="signup.php"><i class="glyphicon glyphicon-plus"></i> Add User</a>
                </div>
                <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <td>Username</td>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Phone number</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <?php if($users != null): ?>
                    <tbody id="form-list-client-body">
                    <?php foreach($users as $user): ?>
                        <tr>
                            <td><h5><a href="myAccount.php?id=<?= $user['id'] ?>"><?= $user['username'] ?></a></h5></td>
                            <td><h5><?= $user['firstName'] ?></h5></td>                    
                            <td><h5><?= $user['lastName'] ?></h5></td> 
                            
                            <?php $phoneNum = setPhoneNumberFormat($user['phoneNumber']); ?>
                            <td><h5><?= $phoneNum ?></h5></td>                          
                            <td><h5><?= $user['email'] ?></h5></td>  
                            <td>
                                <a href="myAccount.php?id=<?= $user['id'] ?>" title="view this user" class="btn btn-default btn-sm "> <i class="glyphicon glyphicon-eye-open text-primary"></i> </a>
                                <a href="edit_user.php?id=<?= $user['id'] ?>" title="edit this user" class="btn btn-default btn-sm "> <i class="glyphicon glyphicon-edit text-primary"></i> </a>
                                <a href="process_user.php?id=<?=$user['id']?>" title="delete this user" class="btn btn-default btn-sm" onclick="return confirm('Are you sure you wish to delete this user?')"> <i class="glyphicon glyphicon-trash text-danger"></i> </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>

                <?php else: ?>
                    <p>No services found</p>
                <?php endif; ?>
            </form>
        </div>

        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="js/popper.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/mdb.js"></script>
        <script type="text/javascript" src="js/addons/datatables.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#dtBasicExample').DataTable();
                $('.dataTables_length').addClass('bs-select');
            });
        </script> 
    
    </body>
</html>