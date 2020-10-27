<!-- Navigation bar below header for page navigation -->
<!-- Navigation bar lists different items depending on the role (RBAC) -->
<div id="nav-bar">
    <div id="nav-content">
    <?php
        // Load menu buttons depending on the role
        if($roletype == "1"){
            ?>
            <button id="nav-data" class="nav-active"><i class="las la-project-diagram"></i></i>&nbsp;Data</button>
            <button id="nav-videos"><i class="las la-video"></i>&nbsp;Videos</button>
            <button id="nav-profile"><i class="las la-user-circle"></i>&nbsp;Profile</button>
            <?php
        }
        elseif($roletype == "2"){
            ?>
            <!-- <button id="nav-patients-physician-visualization" class="nav-active"><i class="las la-project-diagram"></i>&nbsp;Data</button> -->
            <button id="nav-patients-physician" class="nav-active"><i class="las la-procedures"></i>&nbsp;Patients</button>
            <button id="nav-profile"><i class="las la-user-circle"></i>&nbsp;Profile</button>
            <?php
        }
        elseif($roletype = '3'){
            ?>
            <button id="nav-patients-researcher" class="nav-active"><i class="las la-procedures"></i>&nbsp;Patients</button>
            <button id="nav-rss-news"><i class="las la-rss"></i>&nbsp;News</button>
            <button id="nav-profile"><i class="las la-user-circle"></i>&nbsp;Profile</button>
            <?php
        }
        ?>
    </div>
</div>
<!-- Load default page content for the roles -->
<!-- Commented out, because it is now downe by jQuery (script.js) -->
<div class="content-container">
    <?php
        /*if($roletype == "1"){
            include ("content/content_patient.php"); 
        }
        elseif($roletype == "2"){
            include ("content/content_physician.php"); 
        }
        elseif($roletype = '3'){
            include ("content/content_researcher.php"); 
        }*/
    ?>
</div>