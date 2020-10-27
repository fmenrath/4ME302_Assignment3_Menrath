<?php session_start();
include 'config.php';

//Create the connection to the authenticated adapter 
try{
    $hybridauth = new Hybridauth\Hybridauth($config);
    $adapter = $hybridauth->authenticate($_SESSION['provider']);
}
catch(Exception $e){
    //If the connection fails (e. g. unauthenticated user types in home.php-URL in the address bar directly, redirect to login)
    Header("Location:index.php");
}

//Store the necessary data in session variables
$userProfile = $adapter->getUserProfile();
$_SESSION['email'] = $userProfile->email;
$_SESSION['name'] = $userProfile->firstName . " " . $userProfile->lastName;
$_SESSION['photoURL'] = $userProfile->photoURL;


//Establish a connection to the MySQL database
include ("includes/dbconnect.php"); ?>

<!--- HTML for the main page.-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PDinfo</title>
        <!-- Icon Webkits -->
        <script src="https://kit.fontawesome.com/04b6d90103.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- Data visualization-->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.18/c3.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.16.0/d3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.18/c3.min.js"></script>
        <script src="script/rainbowvis.js"></script>
        <!-- Location Picker-->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
        <script src="script/leaflet-providers.js"></script>
        <!-- Import Local Scripts & Stylesheet -->
        <script src="script/script.js"></script>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!--- Check authentication -->
        <?php include ("includes/auth_check.php"); ?>
        <!--- Display header -->
        <?php include ("includes/header.php"); ?>
        <!--- Display content (role-based-access control) -->
        <?php include ("includes/content_control.php")?>
    </body>
</html>