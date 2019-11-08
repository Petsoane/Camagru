<?php
    session_start();
    include_once("../config/user.class.php");

    if (!isset($_SESSION['username'])){
        header("location: ../login.php");
    }
    if (isset($_GET['name']))
        $image_name = $_GET['name'];
    
    if (isset($_POST['submit'])){
        $image_name = $_POST['image'];
        if ($_POST['comment'] != null){
            $user = User::start_connection('camagru');
            $user->comment($_SESSION['username'], $image_name, $_POST['comment']);
            # get user information so that i can send the email
            $image_owner = $user->get_image_user($image_name);
            $result = $user->get_info('users', $image_owner);
            $email = $result[0]['email'];
            $subject = "Appoligies and Like";
            $message = "You sad sick social slave just got a like";
            $user->send_mail($email, $message,$subject);
            header("location: ../index.php");
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Comment</title>
        <meta charset='UTF-8'>
        <link rel="stylesheet" href="../style/style.css">
        <script src="https://kit.fontawesome.com/16cfdb264b.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class='user-menu'>
            <i class="fas fa-users-cog user"></i>
            <div class="dropdown-content">
                <a href="../index.php">Back</a>
                <a href="../snap.php">Take A Picture</a>
                <a href="../profile.php">Account</a>
            </div>
        </div>
        <div class='comment-div'>
            <img id="image" src="<?php echo'uploads/'.$image_name; ?>" id="comment_form">
            <form method="post" action="comment.php">
                <input type='text' hidden name='image' value='<?php echo $image_name;?>'>
                <textarea rows='6' name="comment" placeholder="enter your comments" id='comment'></textarea>
                <br>
                <input type='submit' name='submit' value="Submit">
            </form>
        </div>
    </body>
</html>