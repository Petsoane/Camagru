<?php
    # start session
    session_start();
    require_once "../config/user.class.php";

    # varify the email addr
    echo $_GET['code'];
    echo '<br>'.$_SESSION['verify'];
    if (isset($_GET['code']) && ($_SESSION['verify'] === $_GET['code'])){
       $user = User::start_connection('camagru');
       
       #update the verified field.
       $user->update("users", "verified", 1, $_SESSION['username']);
       header("location: index.php");
    }
    else {
        echo "The email sending will be finalised at the end of this project<br";
    }
?>