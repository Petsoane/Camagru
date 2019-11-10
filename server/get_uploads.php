<?php
require_once("config/setup.php");

# start by making sure the user is logged in.
if (!isset($_SESSION['username'])){
    header("location: ../login.php");
}
# get User connection
$user = User::start_connection('camagru');
# get All the post from the database.
$posts = $user->get_posts($_SESSION['username']);

foreach($posts as $value){
    $img_name = $value['image_name'];
    $img = 'server/uploads/';
    $img .= $value['image_name'];
    echo "<div class='post'>
     <img class='image' src=$img> 
     <div class='buttons'>
        <a href='server/like.php?name=$img_name'><button class='button like'>Like</button></a>
        <a href='server/comment.php?name=$img_name'><button class='button comment'>Comment</button></a>
     </div>
     </div>";
}
?>

