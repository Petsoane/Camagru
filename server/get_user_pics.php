<?php
    include_once ('config/setup.php');

    if (!isset($_SESSION['username'])){
        $_SESSION['msg'] = 'You must login in first, please';
        header('location: login.php');
    }
    $username = $_SESSION['username'];
    $path = 'server/uploads/';
    $user = User::start_connection('camagru');
    # check if the user
    $post = $user->get_user_posts($username);

    foreach($post as $value){
        $img_name = $value['image_name'];
        $img_path = $path;
        $img_path .= $value['image_name'];
        echo "
        <div class='post'>
     <img class='image' src=$img_path> 
     <div class='buttons'>
        <a href='server/delete.php?name=$img_name'><button class='button like'>DELETE</button></a>
     </div>
     </div>";
    }
?>