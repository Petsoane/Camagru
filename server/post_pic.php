<?php
    require_once "config/setup.php";

    # Start session
    session_start();
    
    if (isset($_SESSION['username'])){
        $username = $_SESSION['username'];
        $user = User::start_connection('camagru');
        if (isset($_POST['submit']) && (strpos($_POST['img'], 'data:image/png;base64') === 0)){
            # Get the image string and prepare it.
            $img = $_POST['img'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);

            # decode the data.
            $data = base64_decode($img);
            # get the file name.
            $file_name = 'img'.$username.'_'.date("m_h_Y_d").'_'.time().".png";

            # Create the file path.
            $path = 'server/uploads/'.$file_name;

            # Save the file and add to the database.
            if (file_put_contents($path, $data)){
                $user->add_image($file_name, $username);
            } else {
                echo "There was a problem with saving the file content.";
            }
        }
    }
?>