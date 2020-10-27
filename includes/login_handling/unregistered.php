<div class="content-container">
    <!-- Info about denied access (no email in database) -->
    <div class="head-text">
        <p class="heading" style="font-size:1.4em;">You are not registered.</p>
        <p class="h3">There is no match with your e-mail in our database.</p>
        <a href="logout.php" class="">Back to Login</a>
        <hr style="margin-top: 30px;/* color: white !important; *//* background: white !important; */border: 1px solid #e9e2e2;">
    </div>

    <!-- Registration Form (Optional alternative) -->
    <div id="registration-content">
        <p class="h3" style="margin: 20px 0 20px;text-align: center;">Alternatively you can register below.</p>
        <form action="includes/login_handling/register_user.php" id="registration" method="post">
            <label for="email">Email</label>
            <input type="text" placeholder="" name="email" id="email" value='<?php echo $mail?>' readonly>

            <label for="role">Role</label>
            <input type="text" placeholder="" name="role" id="role" value='<?php echo $role?>' readonly>

            <label for="username">Username</label>
            <input type="text" placeholder="" name="username" id="username" maxlength="20" required>

            <label for="org">Organization</label>
            <select name="org" id="org" required>
                <option value=""></option>
                <option value="1">Hospital</option>
                <option value="2">LNU University</option>
            </select>
            <!-- Patients must also provide their location -->
            <?php if($role == 'patient'){
                ?>
            <label for="lat">Latitude</label>
            <input type="text" placeholder="format: xx.xxxx" name="lat" id="lat" pattern="[0-9][0-9].[0-9][0-9][0-9][0-9]" required>

            <label for="long">Longitude</label>
            <input type="text" placeholder="format: xx.xxxx" name="long" id="long" pattern="[0-9][0-9].[0-9][0-9][0-9][0-9]" required>        
            <?php    
            }
            ?>
            <button type="submit" name="register" id="btn-register">Register</button>
        </form>

    </div>
</div>