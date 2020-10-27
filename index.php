<?php
session_start();
include 'config.php';
?>

<!--- HTML for the login page.-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/04b6d90103.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="script/script.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <title>PDinfo - Login</title>
</head>
<body>
    <div class="head-text">
        <p class="h1" style="margin-top: 30px;">4ME302: Assignment 3</hp>
        <p class="h3">Authentication service and access roles</p>
    </div>
    <div class="btn-card">
        <div class="btn-card-content">
            <p id="note">Select your role</p>
            <!-- Role Buttons -->
            <div class="btn-group">
                <button type="button" id="btn-patient"><i class="las la-user-injured"></i></i></i>&nbsp;Patient</a>
                <button type="button" id="btn-physician"><i class="las la-stethoscope"></i></i></i>&nbsp;Physician</a>        
                <button type="button" id="btn-researcher"><i class="las la-file-medical-alt"></i></i>&nbsp;Researcher</a>
            </div>
            <p id="note-small" style="font-size: 0.8em;">Full access for registered users only.</p>
        </div>
    </div>
</body>
</html>











