<?php 
//This file checks the user's credentials after a successful oauth_login and assigns a role.
//It acts as the main logic behind the authentication process.
//It is included at the top of the "home.php" main page, so therefore it is not possible to skip the login process with manual URLs.

//1) ---------- Check if the user is authenticated with an email; if not --> redirect to login page.
if(!isset($_SESSION['email'])){
    Header("Location:index.php");
}else{
    //Store e-mail in a variable
    $mail = $_SESSION['email'];
}

//2) ---------- Depending on the chosen auth-provider, assign a role.
if($_SESSION['provider'] == 'google'){
    $roletype = '1';
    $role = 'patient';
}
elseif($_SESSION['provider'] == 'twitter'){
    $roletype = '2';
    $role = 'physician';
}
elseif($_SESSION['provider'] == 'github'){
    $roletype = '3';
    $role = 'researcher'; //default = basic researcher, will get overwritten if it is a junior
}

$username = '';
$userid = '';
$org = '';

//3) ---------- Check for database matches
//Idea: If the user's email is in the table and he has chosen the correct auth_service for the role that is stored in the database --> set variables
$result = mysqli_query($conn, "SELECT user.userID, user.username, user.email, organization.name AS org, role.name, user.Lat, user.Long 
FROM user 
JOIN organization ON user.Organization = organization.organizationID 
JOIN role ON user.Role_IDrole = role.roleID 
WHERE user.email = '$mail'");

//If there is match, assign the correct role; else assign the role 
//Assumption: An email can only registered once.
if ($result->num_rows == 1) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        //Wrong login provider (email match, but wrong service)
        if($row["name"] != $role){
            if(strpos($row["name"], $role) == false) {
                $role = 'wrong-provider';
                include 'login_handling/wrong_provider.php';
                exit; 
            }
        }
        //Safe the necessary variables for later usage
        $username = $row["username"];
        $userid = $row["userID"];
        $org = $row["org"];
        $status = 'registered';
        $lat = $row["Lat"];
        $long = $row["Long"];
        $role = $row["name"];

    }
} //Unregistered User (no email match)
elseif($result->num_rows == 0){
    $userid = '';
    $status = 'unregistered';
    include 'login_handling/unregistered.php';
    exit; 
} 

//Assign session variables for further usage (e.g. in the profile page)
$_SESSION['role'] = ucfirst($role);
$_SESSION['roletype'] = $roletype;
$_SESSION['status'] = $status;
$_SESSION['org'] = ucfirst($org);
$_SESSION['username'] = $username;
$_SESSION['userid'] = $userid;
$_SESSION['lat'] = $lat;
$_SESSION['long'] = $long;
?>



