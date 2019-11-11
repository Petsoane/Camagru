<?php
    session_start();
    require_once "config/setup.php";

    if (!isset($_SESSION['username'])){
        $_SESSION['msg']= 'login first';
        header("location: camagru/login.php");
    }
    # Get the user information
    $user = User::start_connection('camagru');
    $user_info = $user->get_info("users", $_SESSION['username']);
    # Get the user informatnion.
    $username =  $user_info[0]['username'];
    $firstName = $user_info[0]['firstName'];
    $lastName = $user_info[0]['lastName'];
    $email = $user_info[0]['email'];
    $get_email = $user_info[0]['send_email'];
    $errors = array();

    echo $get_email.'<br>';
    # Check if the user is trying to change the user information.
    if (isset($_POST['update_info'])){
        # Get get changes to the email. These will be considered temporary.
        $t_username = $_POST['username'];
        $t_firstName = $_POST['firstName'];
        $t_lastName = $_POST['lastName'];
        $t_email = $_POST['email'];
        $t_password1 = $_POST['password_1'];
        $t_password2 = $_POST['password_2'];
        $t_send_email = !isset($_POST['send_email']) ? '0' : $_POST['send_email'];

        # validate the user information
        if (empty($t_firstName)) { array_push($errors, "Name is required"); }
        if (empty($t_lastName)) { array_push($errors, "Surname is required"); }
        if (empty($t_username)){ array_push($errors, "Username is requires");}
        if (empty($t_email)){ array_push($errors, "Email is required"); }
        
        if (!empty($t_password1)){
            if ($t_password1 != $t_password2){
                array_push($errors, "The two passwords do not macth");
            }
            else {
                $containsLetters = preg_match('/[a-z]/', $t_password1);
                $containsUppercase = preg_match('/[A-Z]/', $t_password1);
                $containsDigits = preg_match('/\d/', $t_password1);
                $containsSpecial = preg_match('/[^a-zA-Z]/', $t_password1);
                if (!$containsLetters){
                    array_push($errors, "The password must contain atleast a number");
                }
                if  (!$containsDigits){
                    array_push($errors, "The password must contain atleast one digit");
                }
                if (!$containsUppercase){
                    array_push($errors, "The password must contain atleast one uppercase letter");
                }
                if (!$containsSpecial){
                    array_push($errors, "The password must contain atleast one speacial character");
                }
            }
        }
        
        if (count($errors) == 0){
            # Change the new information.
            if ($t_username !== $username){ // work on the username
                $user->update("users", "username", $t_username, $_SESSION['username']);
                $username = $t_username;
                $_SESSION['username'] = $username;
            }
            if ($t_firstName !== $firstName){ // Change the firstname
                $user->update("users", "firstName", $t_firstName, $_SESSION['username']);
                $firstName = $t_firstName;
            }
            if ($t_lastName !== $lastName){ // Change the lastName
                $user->update('users', "lastName", $t_lastName, $_SESSION['username']);
                $lastName = $t_lastName;
            }
            if ($t_email !== $email){ // change the email
                $user->update('users', 'email', $t_email, $_SESSION['username']);
                $email = $t_email;
            }
            if ($t_send_email != $get_email){ //  make sure that the user cannot recieve the email if not set
                $user->update("users", 'send_email', $t_send_email  , $_SESSION['username']);
                $get_mail = $t_send_email;
            }
        }
    }
?>