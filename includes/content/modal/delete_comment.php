<?php
session_start();
// This script inserts a comment into the database (annotation functionality)
include "../../dbconnect.php";

//Assign variables for delete
$noteID= $_GET["note-id"];

//Create the Delete SQL Statement: Part1: Delete the note
$sql1 = "DELETE FROM note 
WHERE note.noteID = $noteID";

//Create the Delete SQL Statement: Part2: Change the remaining note IDs if necessary
$sql2 = "UPDATE note
SET note.noteID = note.noteID - 1
WHERE note.noteID > '".$noteID."'";

//Execute the SQL statements
mysqli_query($conn, $sql1);
mysqli_query($conn, $sql2);
Header("Location: ../../../home.php");

