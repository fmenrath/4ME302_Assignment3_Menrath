<?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

//Establish a connection to the MySQL database
include ("../dbconnect.php");

//Get variables
$patient = $_GET["patient"];
$roletype = $_SESSION['roletype'];


//SQL query for therapy table
$therapy = mysqli_query($conn, 
"SELECT therapy.therapyID, therapy_list.name AS therapy, medicine.name, therapy_list.Dosage
FROM therapy
INNER JOIN therapy_list ON therapy.TherapyList_IDtherapylist = therapy_list.therapy_listID
INNER JOIN medicine ON therapy_list.Medicine_IDmedicine = medicine.medicineID
WHERE therapy.User_IDpatient = '$patient'");

//SQL query for test session table
$testsession = mysqli_query($conn, 
"SELECT test_session.test_SessionID, test_session.DataURL, test.testID, test.dateTime, therapy.therapyID
FROM therapy
INNER JOIN test ON therapy.therapyID = test.Therapy_IDtherapy
INNER JOIN test_session ON test.testID = test_session.Test_IDtest 
WHERE therapy.User_IDpatient = '$patient'");

//SQL queries for exercise lists
$exercises = mysqli_query($conn, 
"SELECT test_session.DataURL
FROM therapy
INNER JOIN test ON therapy.therapyID = test.Therapy_IDtherapy
INNER JOIN test_session ON test.testID = test_session.Test_IDtest 
WHERE therapy.User_IDpatient = '$patient'");

$exercises2 = mysqli_query($conn, 
"SELECT test_session.DataURL
FROM therapy
INNER JOIN test ON therapy.therapyID = test.Therapy_IDtherapy
INNER JOIN test_session ON test.testID = test_session.Test_IDtest 
WHERE therapy.User_IDpatient = '$patient'");
?>

<!-- MAIN CONTENT -->
<div id="patient-view-top">
    <p class="heading">Patient activity</p>
    <button type="button" id="btn-return-overview" value="<?php echo $roletype?>">Return</button>
</div>
<p class="h3">Patient ID: <?php echo $patient?></p>


<div id="patient-view-content">
    <!-- List of therapies -->
    <p class="patient-view-heading">Therapies</p>
    <?php 
    if ($therapy->num_rows > 0) {
    ?>
    <table class="therapy-list">
        <thead>
            <tr>
                <th>Therapy ID</th>
                <th>Therapy</th>
                <th>Medicine</th>
                <th>Dosage</th>
            </tr>
        </thead>
        <tbody>
        <?php
        while($row = $therapy->fetch_assoc()) {
        ?>
            <tr>
                <td><?php echo $row["therapyID"]?></td>
                <td><?php echo $row["therapy"]?></td>
                <td><?php echo $row["name"]?></td>
                <td><?php echo $row["Dosage"]?></td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    <?php 
    }else{
    ?>
    <p>This patient did not take part in a therapy.</p>
    <?php 
    }
    ?>
    </table>

    <!-- Test session list/table -->
    <p class="patient-view-heading">Test sessions</p>
    <?php 
    if ($testsession->num_rows > 0) {
    ?>
    <table class="test-session-list">
        <thead>
            <tr>
                <th>Session ID</th>
                <th>Session Data</th>
                <th>Test ID</th>
                <th>Test Date</th>
                <th>Therapy ID</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
        <?php
        while($row = $testsession->fetch_assoc()) {
        ?>
            <tr>
                <td>
                    <?php
                    echo $row["test_SessionID"];
                    $currTestSession = $row["test_SessionID"];
                    ?>
                </td>
                <td><?php echo $row["DataURL"]?></td>
                <td><?php echo $row["testID"]?></td>
                <td><?php echo $row["dateTime"]?></td>
                <td><?php echo $row["therapyID"]?></td>
                <td>
                    <?php
                    // Display any notes for the test session
                    $session_notes = mysqli_query($conn,"SELECT note.note, user.username
                    FROM note
                    INNER JOIN user ON note.User_IDmed = user.userID
                    WHERE note.Test_Session_IDtest_session = '$currTestSession'");
                    
                    if ($session_notes->num_rows > 0) {
                        while($row = $session_notes->fetch_assoc()) {
                            echo '<i>'.$row["username"] . ':</i> ' . $row["note"] . '<br>';
                        }
                    }else{
                        echo "-";
                    }
                    ?>
                </td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>

    <!-- Exercise data -->
    <!-- <p class="patient-view-heading" style="text-align: center; font-size: 1.3em;">Exercise data</p> -->
    <div class="exercise-columns">
        <div class="column">
            <p class="exercise-heading">Spiral drawing <i class="las la-pencil-alt"></i> </p>
            <!-- List spiral drawing exercises -->
            <?php
            while($row = $exercises->fetch_assoc()) {
                $currDataURL = $row["DataURL"];
                $currCSV = "../../data/" . $currDataURL . ".csv";
                
                //Open the CSV file
                if (($handle = fopen($currCSV, "r")) !== FALSE) {
                    $data = fgetcsv($handle, 1000, ",");

                    // If it is button tapping data, list it
                    if(in_array("button", $data) == FALSE){
                        ?>
                        <div class="exercise-list-item">
                            <!---DataURL name -->
                            <p class="item-name" value="<?php echo $currDataURL?>"><?php echo $currDataURL . ".csv"?></p>
                            <div class="list-item-buttons">
                                <!---View Button-->
                                <button type="button" class="btn-data-view">
                                    <i class="fas fa-code"></i>
                                </button>

                                <!---Visualize Button-->
                                <button type="button" class="btn-data-visualize" value="<?php echo $patient?>">
                                    <i class="fas fa-search"></i>
                                </button>

                                <!---Download Button-->
                                <button type="button" class="btn-data-download">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </div>
                        <?php
                    }
                }
            };
            ?>
        </div>      

        <!-- List Button tapping exercises -->
        <div class="column">
            <p class="exercise-heading"> Button tapping <i class="las la-hand-point-down"></i></p>
            <?php
            while($row = $exercises2->fetch_assoc()) {
                $currDataURL = $row["DataURL"];
                $currCSV = "../../data/" . $currDataURL . ".csv";

                //Open the CSV file
                if (($handle = fopen($currCSV, "r")) !== FALSE) {
                    $data = fgetcsv($handle, 1000, ",");

                    // If it is button tapping data, list it
                    if(in_array("button", $data) == TRUE){
                        ?>
                        <div class="exercise-list-item">
                            <!---DataURL name -->
                            <p class="item-name"><?php echo $currDataURL . ".csv"?></p>
                            <div class="list-item-buttons">
                                <!---View Button-->
                                <button type="button" class="btn-data-view">
                                    <i class="fas fa-code"></i>
                                </button>

                                <!---Visualize Button-->
                                <button type="button" class="btn-data-visualize" value="<?php echo $patient?>">
                                    <i class="fas fa-search"></i>
                                </button>

                                <!---Download Button-->
                                <button type="button" class="btn-data-download">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </div>
                        <?php
                    }
                }
            };
            ?>
        </div>
        <?php 
    }else{
    ?>
    <p>There are no recorded test sessions or exercises for this patient.</p>
    <?php 
    }
    ?>
    </div>
</div>
<!-- Modal Window (Default: hidden) -->
<div id="data-modal"></div>


