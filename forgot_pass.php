<?php
    # Start session.
    session_start();

    include_once ("config/user.class.php");
    
    # Create a object.
    $user = User::start_connection('camagru');
    $errors = array();
    $email = '';
    # get the user email
    if (isset($_POST['send_link'])) {
        $email = $_POST['email'];

        echo "THe email is set $email<br>";
        # error check the username
        if (empty($email)) { array_push($errors, "Please enter email");}
        # get the user name.
        if (count($errors) == 0){
            $username = $user->get_email_user($email);
            if ($username != NULL){
                echo "The user name is set $username<br>";
                $_SESSION['t_username'] = $username;
                $subject = "You forgot your password you nitwit";
                $message = 'localhost:8080/camagru/change.php';
                $user->send_mail($email, $message, $subject);
                header("location: change.php");
            }
            else {
                array_push($errors, "The email has no user attached");
            }
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
                    <label>Enter Email </label>
                    <input type='email' name='email' value='<?php echo $email ?>'>
                </div>
                <input type='submit' name='send_link' value='Send Link' class='btn'>
            </form>
    </body>
</html>