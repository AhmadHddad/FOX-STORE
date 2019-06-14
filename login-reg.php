<?php
include('reg.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="resources\css\style.css">
    <title>Document</title>
    <script>
    function redirectme() {
        window.location.replace('index.php');    
    }
    </script>

<body>
    <div id="wrapper">
        <input type='checkbox' id='form-switch'>
        <form class="logform" id='login-form' action="login-reg.php" method='post'>
            <?php include('errors.php'); ?>
            <h1 id="title">Log In</h1>
            <input class="loginput" type="text" placeholder="Username" name="username" required>
            <input class="loginput" type="password" placeholder="Password" name="password" required>
            <div style="text-align:center">
                <button class="logbutton" type='submit' name="login_user">Login</button>
                <label style="background-color:darkcyan;" class="loganchor" for='form-switch'><span>No account? Sign Up</span></label>
                <br>
                <button onclick="redirectme()" type="button" class="cancelbtn">Cancel</button> </div>
        </form>
        <form class="logform" id='register-form' action="login-reg.php" method='post'>
            <h1 id="title">Register</h1>
            <input class="loginput" name="username" type="text" placeholder="Username" value="<?php echo $username; ?>" required>
            <input class="loginput" name="email" type="email" placeholder="Email" value="<?php echo $email; ?>" required>
            <input class="loginput" type="password" name="password_1" placeholder="Password" required>
            <input class="loginput" type="password" name="password_2" placeholder="Re Password" required>

            <div style="text-align:center">
                <button class="logbutton" type='submit' name="reg_user">Register</button>
                <label style="background-color:darkcyan;" class="loganchor" for='form-switch'>Already Member ? Sign In Now..</label>
                <br>
                <button onclick="redirectme()" type="button" class="cancelbtn">Cancel</button>
            </div>
        </form>



    </div>
</body>

</html>