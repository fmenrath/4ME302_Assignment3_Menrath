<?php session_start();
include 'config.php';

//Create the connection to the authenticated adapter 
try{
    $hybridauth = new Hybridauth\Hybridauth($config);
    $adapter = $hybridauth->authenticate($_SESSION['provider']);
}
catch(Exception $e){
    //Header("Location:index.php");
}

//Disconnect (=Logout) the adapter
try{
    $adapter->disconnect();
}
catch(Exception $e){
    echo 'Oops, we ran into an issue! ' . $e->getMessage();
}

//Destroy session data and redirect to the login page.
session_destroy();
header("Location:index.php");


