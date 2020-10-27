<?php
session_start();
include 'config.php';

if(isset($_GET["provider"])){

    //Catch the selected login provider and store it in a session variable
    $provider_name = $_GET["provider"];
    $_SESSION['provider'] = $provider_name;

    //Authentication process (automatically redirects to home.php as callback)
    try{
        $hybridauth = new Hybridauth\Hybridauth($config);
        $adapter = $hybridauth->authenticate($provider_name);
    }
    catch(Exception $e){
        echo 'Oops, we ran into an issue! ' . $e->getMessage();
    }
}
?>

<!-- Safety measure: Login dialog doesn't load after failed logouts -->
<p style="text-align: center; margin-top: 30px; font-size: 1.2em; font-family:Lato;">The Login dialog is not loading. You may already be signed in. <a href="home.php">Go to the main page.</a></p>

