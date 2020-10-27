<?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

include ("../dbconnect.php"); 

//Retrieve the patients' base data
$basedata = mysqli_query($conn, "SELECT user.userID, user.username, user.email, user.Lat, user.Long
FROM user
WHERE user.Role_IDrole = '1'");

//Retrieve the patients' locations (users without location are not considered)
$locations = mysqli_query($conn, 
"SELECT user.userID, user.username, user.email, user.Lat, user.Long
FROM user
WHERE user.LAT IS NOT NULL AND user.Role_IDrole = '1'");

//Create an array for the patients' locations (will be passed to jQuery)
$user_locations = [];
while($row = mysqli_fetch_assoc($locations))
{
    $user_locations[] = $row;
}
?>

<!-- Geographical Overview of patients -->
<p class="h3">This map shows the locations of our patients.</p>

<div id="map"></div>
<script>
    //Get the users' info
    var userInfo = <?php echo json_encode($user_locations); ?>;

    //Create the Map
    var map = L.map('map').setView([51.505, -0.09], 5);

    //Choose the map style
    var CartoDB_VoyagerLabelsUnder = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_labels_under/{z}/{x}/{y}{r}.png', {
        attribution: '',
        subdomains: 'abcd',
        maxZoom: 19
    }).addTo(map);
    
    //Create an array for markers   
    var markerArray = [];
    
    //Add markers
    for(var i = 0; i < userInfo.length; i++) {
        var obj = userInfo[i];
        L.marker([obj.Lat, obj.Long]).addTo(map)
        .bindPopup('<b>User ID:</b>  '+obj.userID + '<br><b>Username:</b> '+obj.username+'<br>'+obj.email+'<br> <button type="button" class="activity-link" value="'+obj.userID+'">View activity</button>')
        markerArray.push(L.marker([obj.Lat, obj.Long]));
    }
    
    //Resize map to show all the markers
    var group = new L.featureGroup(markerArray);
    map.fitBounds(group.getBounds().pad(0.1));
</script>

<!-- Table overview of patients -->
<?php
if ($basedata->num_rows > 0) {
    ?>
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
                    <button type="button" class="btn-therapy-view-researcher" value="<?php echo $currPatientID?>">
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
  <p class="h3">There are no patients in our system.</h3>
<?php
}
?>




