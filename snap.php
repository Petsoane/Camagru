<?php 
include('server/post_pic.php'); 

if (!isset($_SESSION['username'])){
    header("location: login.php");
}
?>
<!DOCTYPE html>

<html>
    <head>
        <title>Take picture </title>
        <meta charset="utf-8">
        <link rel='stylesheet' href='style/pic_style.css'>
        <script src="https://kit.fontawesome.com/16cfdb264b.js" crossorigin="anonymous"></script>
    </head>  
    <body>
        <div class='user-menu'>
            <i class="fas fa-users-cog user"></i>
            
            <div class="dropdown-content">
                <a href="login.php"> Logout </a>
                <a href="index.php">Back Home</a>
            </div>
        </div>
        
        <div id="picture-div">
            <!-- Stream video via the webcam. -->
            <div id="video-div">
                <div id="video-wrap">
                    <video id="video" autoplay playsinline></video>
                </div>
                <!-- trigger canvas web api -->
                <div class="controller">
                    <button id="snap">Capture</button>
                </div>
            </div>
            <!-- The div for the picture -->
            <div id="canvas-wrap">
                <!-- Webcam vidoe snap -->
                <canvas id="canvas"></canvas>
                <form method="post" action="" onsubmit="prepareImg();">
                    <input id="inp_img" name="img" type='hidden' value="">
                    <input id="bt_upload" type="submit" name="submit" value="upload">
                </form>
                <div class="stickers">
                    <img src='server/stickers/cool.png' id="cool_img" hidden >
                    <button id='cool'>Add_sticker</button>
                    <select id='select_sticker'>
                        <option value='none'>Chose a sticker</option>
                        <option value='server/stickers/cool.png'>cool</option>
                        <option value='server/stickers/Im_different.png'>IMDIFF</option>
                        <option value='server/stickers/squidab.png'>SQUIDAB</option>
                        <option value='server/stickers/Yeah_broh.png'>YEAH</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="user-pic">
            <?php include('server/get_user_pics.php'); ?>
        </div>
    </body>
    <script src="js/take_pic.js"></script>
    <script src="js/upload.js"></script>
    <script src="js/add_sticker.js"></script>
<html>