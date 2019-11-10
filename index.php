<?php 
    session_start();
    include_once("config/setup.php");

  
    if (isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['username']);
        header("location: login.php");
    }

    # Create a user object.
    $user = User::start_connection('camagru');

    # Define constants for the limit of the paginnation.
    $limit = 10;
    # get the page number from the link.
    if (isset($_GET['page'])){
        $current_page = $_GET['page'];
    }
    else{
        $current_page = 1; // This is the start of the pages.
    }

    # get the count of posts/
    $post_count = $user->count();
    echo $post_count.'<br>';

    # Calculate the number of pages needed to hold all pictures.
    $page_lim = ceil($post_count / $limit);
    # calculate the offset need to get the next range.
    $offset = ($current_page - 1) * $limit;
    # get the range of data.
    $range = $user->get_range($offset, $limit);
    // echo $range.'<br>';
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="style/style.css">
        <script src="https://kit.fontawesome.com/16cfdb264b.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class='user-menu'>
            <i class="fas fa-users-cog user"></i>
            <div class="dropdown-content">
                <a href="index.php?logout=true"> Logout </a>
                <a href="snap.php">Take A Picture</a>
                <a href="profile.php">Account</a>
                <a href="login.php">Login</a>
            </div>
        </div>
        <div class="header">
            <h2>Home page</h2>
        </div>
        
        <div class="content">
            <!-- Notification message -->
            <?php if (isset($_SESSION['success'])) : ?>
            <div class="error success">
                <h3>
                    <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </h3>
            </div>
            <?php endif ?>

            <!-- Add display all the post in the databases -->
            <?php
                foreach($range['results'] as $result){
                    $img_name = $result['image_name'];
                    $path = 'server/uploads/';
                    $path .= $img_name;
                    echo "<div class='post'>
                             <img class='image' src=$path> 
                             <div class='buttons'>
                                <a href='server/like.php?name=$img_name'><button class='button like'>Like</button></a>
                                <a href='server/comment.php?name=$img_name'><button class='button comment'>Comment</button></a>
                             </div>
                         </div>";
                }
            ?>
        </div>
        <footer>
            <div class='pagination'>
                <div class="pagination">
                  <a href="<?php if ($post_count < $limit){ echo "#";} else { $prev = $current_page >= 1? $current_page - 1: $current_page;  echo "index.php?page=$prev";}?>">&laquo; previous</a>
                  <a href="#" class='active'><?php echo $current_page; ?></a>
                  <a href="<?php if ($post_count < $limit) { echo '#';} else { $next = $current_page < $page_lim? $current_page + 1: $current_page; echo "index.php?page=$next";}?>">&raquo; next</a>
                </div>
            </div>
        </footer>
    </body>
</html>