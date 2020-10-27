<?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

//Establish a connection to the MySQL database
include ("../dbconnect.php");
?>

<div class="physician-content">
  <p class="heading">Patient overview</p>

  <!-- Display the table of patients -->
  <?php include ("patient_table/researcher_patient_table.php");?>

</div>