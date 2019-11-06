<?php
require_once("config/user.class.php");

# start by making sure the user is logged in.
if (!isset($_SESSION['username'])){
    header("location: ../login.php");
}
# get User connection
$user = User::start_connection('camagru');
# get All the post from the database.
$posts = $user->get_posts($_SESSION['username']);

foreach($posts as $value){
    $img = 'server/uploads/';
    $img .= $value['image_name'];
    echo "<div class='post'>
     <img class='image' src=$img> 
     <div class='buttons'>
        <button class='button like'>Like</button>
        <button class='button comment'>Comment</button> 
     </div>
     </div>";
}
?>

