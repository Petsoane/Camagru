<?php
    # Star session
    session_start();
    require_once("config/user.class.php");

    # Initialize variable.
    $name       = "";
    $lastName   = "";
    $username   = "";
    $email      = "";
    $errors     = array();

    # Start connection 
    $user = User::start_connection("camagru");

    # Register the user.
    if (isset($_POST['reg_user'])){
        # recieve the input from the user.
        $lastName = $_POST['surname'];;
        $name = $_POST['firstName'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password_1 = $_POST['password_1'];
        $password_2 = $_POST['password_2'];

         # form validation: ensure that the form is correctly filled
        # by adding corresponding error massages to the error array.
        if (empty($name)) { array_push($errors, "Name is required"); }
        if (empty($lastName)) { array_push($errors, "Surname is required"); }
        if (empty($username)){ array_push($errors, "Username is requires");}
        if (empty($email)){ array_push($errors, "Email is required"); }
        if (empty($password_1)){ array_push($errors, "Password is required"); }
        if ($password_1 != $password_2){
            array_push($errors, "The two passwords do not macth");
        }
        else {
            $containsLetters = preg_match('/[a-z]/', $password_1);
            $containsUppercase = preg_match('/[A-Z]/', $password_1);
            $containsDigits = preg_match('/\d/', $password_1);
            $containsSpecial = preg_match('/[^a-zA-Z]/', $password_1);
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

        # Check if the user already exists.
        $errors = array_merge($errors, $user->check_user($email, $username));

        if (count($errors) == 0){
            # send verification email.
            $ver_code = md5(rand());
            $_SESSION['code'] = $ver_code;
            $baseUrl =  "https://localhost/camaguru/server/server.php?code=$ver_code";
            $subject = "Varify email";
            $body = "<p> Please open the link to varify - $baseUrl</p>";
            
            if($user->send_mail($email, $body, $subject)){
                if (count($errors) == 0){
                    $user->register_user($username, $name, $lastName, $email, $password_1);
                    
                    # Store the user information
                    $_SESSION['username'] = $username;
                    $_SESSION['name'] = $name;
                    $_SESSION['lastName'] = $lastName;
                    $_SESSION['email'] = $email;
                    
                    $_SESSION['verify'] = $ver_code;
                    $_SESSION['success'] = "You are now logged in from registration page";
                    header("location: server/verify.php?code=$ver_code");
                }
            }
            else {
                array_push($errors, "There was a problem with sending the verify email, check email.");
            }
        }
    }

    # Login the user
    if (isset($_POST['login_user'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username)){
            array_push($errors, "Username is required");
        }
        if (empty($password)){
            array_push($errors, "Password is required");
        }
        if (count($errors) == 0){
            $errors = array_merge($errors, $user->login_user($username, $password));
            if (count($errors) == 0){
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "You are now logged in from login page.";
                header("location: index.php");
            }
        }
    }
?>