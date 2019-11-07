<?php 
    session_start();

    if (!isset($_SESSION['username'])){
        $_SESSION['msg'] = "You must log in first";
        header("location: camagru/login.php");
    }
    if (isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['username']);
        header("location: camagru/login.php");
    }
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="style/style.css">
        <script src="https://kit.fontawesome.com/16cfdb264b.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class='user-menu'>
            <i class="fas fa-users-cog user"></i>
            <div class="dropdown-content">
                <a href="index.php?logout=true"> Logout </a>
                <a href="snap.php">Take A Picture</a>
                <a href="profile.php">Account</a>
            </div>
        </div>
        <div class="header">
            <h2>Home page</h2>
        </div>
        
        <div class="content">
            <!-- Notification message -->
            <?php if (isset($_SESSION['success'])) : ?>
            <div class="error success">
                <h3>
                    <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </h3>
            </div>
            <?php endif ?>

            <!-- Add display all the post in the databases -->
            <?php include("server/get_uploads.php"); ?>
        </div>
    </body>
</html>