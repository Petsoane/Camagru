<?php
    # start session
    session_start();
    require_once "../config/setup.php";

    # varify the email addr
    echo $_GET['code'];
    echo $_SESSION['username'];
    if (isset($_GET['code'])){
       $user = User::start_connection('camagru');
       #update the verified field.
       $user->verify_user($_GET['code'], $_SESSION['username']);
       header("location: ../index.php");
    }
    else {
        echo "Please check your email andclick on the link provided<br>";
    }
?>