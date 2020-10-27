<?php
session_start();
// This script inserts a comment into the database (annotation functionality)
include "../../dbconnect.php";

//Assign variables for insert
$text= $_GET["comment-form"];
$sessionID= $_GET["session-id"];

// Assign the noteID
$notecount = mysqli_query($conn, "SELECT * FROM note");
$noteID = mysqli_num_rows($notecount) + 1;

//Create the Insert SQL Statement
$sql = "INSERT INTO note
VALUES ('".$noteID."', '".$sessionID."', '".$text."', '".$_SESSION["userid"]."')";

//Insert the values and redirect to the main page
mysqli_query($conn, $sql);
Header("Location: ../../../home.php");
