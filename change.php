<?php
    session_start();

    include_once("config/setup.php");
    # create a user.
    $user = User::start_connection('camagru');
    $errors = array();

    # change the password.
    if (isset($_POST['change'])){
        # get the username
        $username =$_SESSION['t_username'];
        $pass_1 = $_POST['pass_1'];
        $pass_2 = $_POST['pass_2'];

        echo $username . '<br>';
        # Validate the input
        if ($pass_1 !== $pass2) {array_push($errors, "The passwords do not match");}

        if (count($errors) == 0){// update the password
            $pass = md5($pass_1);
            $user->update("users", "password", $pass, $username);
            session_destroy();
            header("location: login.php");
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Comment</title>
        <meta charset='UTF-8'>
        <link rel='stylesheet' href='style/style.css'>
    </head>
    <body>
        <div class="header">
            <h2>FORGOT PASSWORD</h2>
        </div>
            <form method='post' action='forgot_pass.php'>
                <?php include_once('server/errors.php'); ?>
                <div class='input-group'>
                    <label>Enter Password </label>
                    <input type='password' name='pass_1'>
                </div>
                <div class='input-group'>
                    <label>Enter Pasword again </label>
                    <input type='password' name='pass_2'>
                </div>
                <input type='submit' name='change' class='btn'>
            </form>
    </body>
</html>