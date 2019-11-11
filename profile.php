<?php include('server/change_profile.php'); ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <link rel="stylesheet" href="style/style.css">
        <script src="https://kit.fontawesome.com/16cfdb264b.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class='user-menu'>
            <i class="fas fa-users-cog user"></i>
            <div class="dropdown-content">
                <a href="index.php?logout=true"> Logout </a>
                <a href="snap.php">Take A Picture</a>
                <a href="index.php">Home</a>
            </div>
        </div>
        <div class="header">
            <h2> Account. </h2>
        </div>
        <form method="post" action="profile.php">
            <?php include('server/errors.php'); ?>
            <div class="input-group">
                <label>Name</label>
                <input type="text" name="firstName" autofocus value="<?php echo $firstName; ?>">
            </div>
            <div class="input-group">
                <label>Surname</label>
                <input type="text" name="lastName"  value="<?php echo $lastName; ?>">
            </div>
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username"  value="<?php echo $username; ?>">
            </div>
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $email; ?>">
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password_1" >
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password_2" >
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="update_info">UPDATE</button>
            </div>
            <div class='input-grop'>
                <label><input type='checkbox' <?php if ($get_email == 1) {echo 'checked="1"';} ?> name='send_email' value='1'>Do you want to recieve an email</label>
            </div>
        </form>
    </body>
</html>