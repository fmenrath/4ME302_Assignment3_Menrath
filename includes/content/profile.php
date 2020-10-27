<?php session_start();?>
<p class="heading">Profile page</p>
<p class="h3">PDinfo has the following information about you:</p>
<div class="profile-area">
    <!-- Profile Picture -->
    <div class="photo-column" style="width:170px;">
        <img src="<?php echo $_SESSION['photoURL']?>" id="profile-picture"/>
        <p id="profile-pic-text" style="font-size: 0.9em; position: relative; left: 17px;">Profile picture</p>

    </div>
    <!-- Basic profile data (no activities or therapy info) -->
    <div class="table-column" style="width:100%">
        <table id="table-profile" style="width:100%">
            <tr>
                <th class="profile-th">Name</th>
                <td class="profile-td"><?php echo $_SESSION['name']; ?></td>
            </tr>
            <tr>
                <th class="profile-th">User</th>
                <td class="profile-td"><?php echo $_SESSION['username'];?></td>
            </tr>
            <tr>
                <th class="profile-th">Role</th>
                <td class="profile-td"><?php echo $_SESSION['role']; ?></td>
            </tr>
            <tr>
                <th class="profile-th">Org.</th>
                <td class="profile-td"><?php echo $_SESSION['org']; ?></td>
            </tr>
            <tr>
                <th class="profile-th">E-Mail</th>
                <td class="profile-td"><?php echo $_SESSION['email']; ?></td>
            </tr>
            <tr>
                <th class="profile-th">Provider</th>
                <td class="profile-td"><?php echo ucfirst($_SESSION['provider']); ?></td>
            </tr>
            <tr>
                <th class="profile-th">Status</th>
                <td class="profile-td"><?php echo $_SESSION['status']; ?></td>
            </tr>
            <!-- Display location for patients -->
            <?php if($_SESSION['role'] == 'Patient'){
                ?>
            <tr>
                <th class="profile-th">Lat.</th>
                <td class="profile-td"><?php echo $_SESSION['lat']; ?></td>
            </tr>
            <tr>
                <th class="profile-th">Long.</th>
                <td class="profile-td"><?php echo $_SESSION['long']; ?></td>
            </tr>
            <?php
            } ?>
        </table>
    </div>
</div>

