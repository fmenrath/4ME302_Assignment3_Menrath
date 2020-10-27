<div class="content-container">
    <!-- The user must sign in with the correct provider, so therefore display an error message if the wrong one is chosen. -->
    <div class="head-text">
        <p class="heading" style="font-size:1.4em;">You have chosen the wrong login provider.</p>
        <p class="h3">Your email is registered in our system, <br> but you must sign in as a <?php echo $row["name"]?>.</p>
        <a href="logout.php" class="">Back to Login</a>
    </div>
</div>