<?php
session_start();
//Registration process
include '../dbconnect.php';

//Assign the userID for the new user
$result = mysqli_query($conn, "SELECT * FROM user");
$userid = mysqli_num_rows($result) + 1;

//Assign the correct roleID
if($_SESSION['provider'] == 'google'){
    $role = 'patient';
    $roleid = "1";
}
elseif($_SESSION['provider'] == 'twitter'){
    $role = 'physician';
    $roleid = "2";
}
elseif($_SESSION['provider'] == 'github'){
    $role = 'researcher';
    $roleid = "3";
}

//Register the new user
if(isset($_POST['register']))
{
    $sql = "INSERT INTO user
    VALUES ('".$userid."','".$_POST["username"]."','".$_POST["email"]."','".$roleid."','".$_POST["org"]."','".$_POST["lat"]."','".$_POST["long"]."')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['registration'] = "success";
        Header("Location: ../../home.php");
        exit;
    }
    else{
        $_SESSION['registration'] = "fail";
        Header("Location: ../../index.php");
    }
}
?>