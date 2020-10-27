<?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$userid = $_SESSION['userid'];
include ("../dbconnect.php"); 

//List the physician's patients
//Retrieve the patients' base data
$basedata = mysqli_query($conn, "SELECT user.userID, user.username, user.email, user.Lat, user.Long
FROM user
INNER JOIN therapy ON user.userID = therapy.User_IDpatient
WHERE therapy.User_IDmed = '$userid'");

//If the physician has patients (=conducting therapies), create a table
if ($basedata->num_rows > 0) {
    ?>
    <p class="h3">The following table contains information about your patients.</p>

    <!-- Create Table Head  -->
    <table class="patient-list" rules="rows">
        <thead>
            <tr>
                <th style="width: 5%;"> ID</th>
                <th>Username</th>
                <th style="width:20%;">E-Mail</th>
                <th>Lat.</th>
                <th>Long.</th>
                <th>Activity</th>
            </tr>
        </thead>
        <tbody>
        <?php
        //Create table rows and fill the cells with the retrieved data.
        while($row = $basedata->fetch_assoc()) {
        ?>
            <tr>
                <td>
                    <?php 
                    echo $row["userID"];
                    $currPatientID = $row["userID"];
                    ?>
                </td>
                <td><?php echo $row["username"]?></td>
                <td><?php echo $row["email"]?></td>
                <td><?php echo $row["Lat"]?></td>
                <td><?php echo $row["Long"]?></td>
                <td>
                    <button type="button" class="btn-therapy-view" value="<?php echo $currPatientID?>">
                        <!-- <i class="las la-external-link-alt"></i> -->
                        <i class="fas fa-external-link-alt" style="font-size: 1.1em;"></i>
                    </button>
                </td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
<?php
}
else{
?>
  <p class="h3">You currently do not have any patients.</h3>
<?php
}
?>

    
