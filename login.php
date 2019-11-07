<?php include('server/server.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login system.</title>
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body>
        <div class="header">
            <h2>Login</h2>
        </div>
        <!-- This is the registrationm form -->
        <form method="post" action="login.php">
            <?php include('server/errors.php'); ?>
            <div class="input-group">
                <label>Username</label>
                <input type="text" autofocus name="username">
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password">
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="login_user">Login</button>
            </div>
            <p>
                Not yet a member? <a href="register.php">Sign up</a>
            </p>
            <p>
                Forgot Password? <a href='#'>change_password</a>
            </p>
        </form>
    </body>
</html>