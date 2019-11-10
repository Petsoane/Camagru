<?php
    session_start();

    include_once("../config/setup.php");

    if (isset($_GET['name'])){
        $user = User::start_connection('camagru');

        $user->delete_img($_GET['name']);
        header("location: ../snap.php");
    }
?>