<?php
    include_once ("../config/user.class.php");
    session_start();

    # check if the user hase logged in
    if  (!isset($_SESSION['username'])){
       $_SESSION['msg'] = "Log in first";
       header("loaction: ../login.php");
    }

    # get the name of the image   
    if (isset($_GET['name'])){
        $user = User::start_connection("camagru");
        $image_name = $_GET['name'];
        echo "Liking $image_name, <br>";
        $user->like($_SESSION['username'], $image_name);
        # send email to the user.
        $image_owner = $user->get_image_user($image_name);
        $result = $user->get_info('users', $image_owner);
        $email = $result[0]['email'];
        $subject = "Appoligies and Like";
        $message = "You sad sick social slave just got a like";
        $user->send_mail($email, $message,$subject);
        header("location: ../index.php");
    }
?>