<?php
    session_start();
    
    require 'connect.php';

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $id) {
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

    } else {
        header("Location: index.php");
        exit;
    }

    function setPhoneNumberFormat($number) {
        $result = substr($number, 0, 3) . '-' .substr($number, 3, 3) . '-' . substr($number, 4, 4);
        return $result;
    }

    if(isset($user['phoneNumber'])) {
        $phoneNum = setPhoneNumberFormat($user['phoneNumber']);
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

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/mdb.min.css" rel="stylesheet">
        <link href="css/addons/datatables.min.css" rel="stylesheet"> 

        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> -->
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

        <div class="container">
        <div class="row">
            <div class="col-10 userPage">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title profileCenter">
                        
                        <!-- <div><i class="fas fa-user-circle"></i><div>                               -->
                            <div class="d-flex justify-content-start">
                            <div class="image-container">
                                    <?php if(file_exists('uploads/'.$_SESSION["id"].'.png')): ?>
                                        <img src="uploads/<?=$_SESSION['id']?>.png" alt="profile" style="width=100%">
                                    <?php else: ?>
                                        <img src="http://placehold.it/150x150" id="imgProfile" style="width: 150px; height: 150px" class="img-thumbnail" />
                                    <?php endif ?>

                                    <form class="middle" method="post" action="uploadImage.php" entype="multipart/form-data">
                                        <input type="submit" class="btn btn-secondary" id="btnChangePicture" value="Change" />
                                        <input type="file" id="image" name="image" />
                                    </form>
                                </div>

                                <div class="userData ml-3 profileCenter">
                                    <h2 class="d-block" style="font-size: 1.5rem; font-weight: bold"><a href="#"><?=$user['username']?></a></h2>
                                    <h6 class="d-block"><a href="javascript:void(0)">1,500</a> Video Uploads</h6>
                                    <h6 class="d-block"><a href="javascript:void(0)">300</a> Blog Posts</h6>
                                    <h6><a href="edit_user.php?id=<?= $user['id']?>" class="btn btn-primary btn-sm">Edit profile</a></h6>
                                </div>                                                 
                            </div>
                                                        
                        </div>

                    

                        <div class="row">
                            <div class="col-12">
                                <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="basicInfo-tab" data-toggle="tab" href="#basicInfo" role="tab" aria-controls="basicInfo" aria-selected="true">Basic Info</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="connectedServices-tab" data-toggle="tab" href="#connectedServices" role="tab" aria-controls="connectedServices" aria-selected="false">Connected Services</a>
                                    </li>
                                </ul>
                                <div class="tab-content ml-1" id="myTabContent">
                                    <div class="tab-pane fade show active" id="basicInfo" role="tabpanel" aria-labelledby="basicInfo-tab">                                  
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">First Name</label>
                                            </div>
                                            <div class="col-md-8 col-6"><?=$user['firstName']?></div>
                                        </div>
                                        <hr />
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Last Name</label>
                                            </div>
                                            <div class="col-md-8 col-6"><?=$user['lastName']?></div>
                                        </div>
                                        <hr />   
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Phone number</label>
                                            </div>
                                            <div class="col-md-8 col-6"><?= $phoneNum?></div>
                                        </div>
                                        <hr />
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Email</label>
                                            </div>
                                            <div class="col-md-8 col-6"><?=$user['email']?></div>
                                        </div>
                                        <hr />
                                    </div>
                                    <div class="tab-pane fade" id="connectedServices" role="tabpanel" aria-labelledby="ConnectedServices-tab">
                                        Facebook, Google, Twitter Account that are connected to this account
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </body>
</html>