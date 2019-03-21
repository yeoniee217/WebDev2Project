<?php
/*****************************************
 *
 *  Purpose: The php file for the blog home page
 *  Author: Jihyeon Lee
 *  Date Created: March 14, 2019
 *
 *****************************************/

    require 'connect.php';

    $query = "SELECT * FROM services ORDER BY id DESC";
    $statement = $db->prepare($query); //Returns a PDOStatement object.
    $statement->execute();        // The query is now executed.
    $services = $statement->fetchAll();  //fetchAll: get an array of all the rows

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Paw Pet Spa</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Carter+One" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="style.css">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/mdb.min.css" rel="stylesheet">
        <link href="css/addons/datatables.min.css" rel="stylesheet">    
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

        <div class="container bootstrap snippet">
            <section id="services" class="current">
                <div class="services-top">
                    <div class="container bootstrap snippet">
                        <div class="row text-center">
                            <div class="col-sm-12 col-md-12 col-md-12">
                                <h2 style="font-size: 45px;line-height: 60px;margin-bottom: 20px;font-weight: 900;">Our Services</h2>
                                <p>One of our excellent stylists will complete <span class="highlight">a customized haircut</span> of your choice.<br/>
                                Whether you prefer their coat long & natural, shaved short, your dog will leave 
                                <span class="highlight">looking and feeling</span> her best.</p>
                            </div>
                        </div>

                        <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="th-sm">Name
                                    </th>
                                    <th class="th-sm">Cost
                                    </th>
                                    <th class="th-sm">Description
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($services as $service): ?>
                                <tr>
                                    <td><?= $service['name'] ?></td>
                                    <td>$<?= $service['cost'] ?></td>
                                    <td><?= $service['description'] ?></td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </section>
        </div>

        <!-- SCRIPTS -->
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