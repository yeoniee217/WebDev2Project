<?php
    session_start();
    
    require_once 'connect.php';

    if(isset($_SESSION["loggedin"])) {
        $cleanId = filter_var($_SESSION['id'], FILTER_SANITIZE_NUMBER_INT);
        
        $query = "SELECT * FROM users WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $cleanId, PDO::PARAM_INT );

        $statement->execute();
        $user = $statement->fetch();

        $imageId = $user['id'];
    }
    // if(isset($_POST["image"])) {
    //     header("Location: myAccount.php");
    //     exit;
    // }

    if(isset($_SESSION["loggedin"]) && $_SESSION['id']!=2 ) {
        $cleanId = filter_var($_SESSION['id'], FILTER_SANITIZE_NUMBER_INT);
        
        $query = "SELECT * FROM users WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $cleanId, PDO::PARAM_INT );

        $statement->execute();
        $user = $statement->fetch(); 

        if (is_null($user['id']))
        {
            header("Location: index.php");
            exit;
        }

    }  

    if(isset($_POST) && file_exists('uploads/'.$_SESSION['id'].'.png') && $_SESSION['id']==2 ) {
        $cleanId = filter_var($_SESSION['id'], FILTER_SANITIZE_NUMBER_INT);
        
        $query = "SELECT * FROM users WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $cleanId, PDO::PARAM_INT );

        $statement->execute();
        $user = $statement->fetch(); 

        $imageId = $user['id'];
    }

    
    if(isset($_SESSION["id"]) && $_SESSION['id']==2 && filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) {
        $cleanId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        $query = "SELECT * FROM users WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $cleanId, PDO::PARAM_INT );

        $statement->execute();
        $user = $statement->fetch(); 

        $imageId = $user['id'];
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
                            <div class="d-flex justify-content-start">
                                <div class="userData ml-1 profileCenter">
                                    <p style="margin-left:35px;"><i class="fas fa-user-circle"></i></p>
                                    <h2 class="d-block" style="font-size: 1.5rem; font-weight: bold; margin-left:20px;"><a href="edit_user.php?id=<?=$user['id']?>"><?=$user['username']?></a></h2>
                                    <p><a href="edit_user.php?id=<?= $user['id']?>" style="width:130px;" class="btn btn-primary btn-sm">Edit profile</a></p>
                                </div> 
                                <div class="image-container">
                                    <?php if(file_exists('uploads/'.$imageId.'.png')): ?>
                                        <img src="uploads/<?=$imageId?>.png" alt="profile" style="width:150px; height:150px">
                                    <?php elseif(file_exists('uploads/'.$imageId.'.jpg')): ?>
                                        <img src="uploads/<?=$imageId?>.jpg" alt="profile" style="width:150px; height:150px">
                                    <?php else: ?>
                                        <img src="http://placehold.it/150x150" id="imgProfile" style="width:150px; height:150px" class="img-thumbnail" />
                                    <?php endif ?>

                                    <form method="post" action="uploadImage.php" enctype='multipart/form-data'>                                        
                                        <div class="custom-file col-6">
                                            <input type="hidden" name="id" value="<?= $user['id'] ?>" />
                                            <input type="file" name="image" id="image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" style="text-align: center !important; font-size:13px;" for="inputGroupFile01">Choose file</label>
                                        </div>
                                        <input type='submit' name='submit' class="btn btn-secondary btn-sm" id="btnChangePicture" value="Change">
                                    </form>

                                    <?php if(file_exists('uploads/'.$imageId.'.png')): ?>
                                    <form method="post" action="deleteImage.php">
                                        <input type='submit' name='delete' class="btn btn-secondary btn-sm" id="btnChangePicture" value="Delete">
                                    </form>
                                    <?php endif ?>
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
                                <div class="tab-content ml-2" id="myTabContent">
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

    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/mdb.js"></script>
        <script type="text/javascript" src="js/addons/datatables.min.js"></script>
    </body>
</html>