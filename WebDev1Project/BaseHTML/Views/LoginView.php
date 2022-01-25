

<head title="Ticketstubs">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../css/manualStyle.css">
    <title>Ticketstubs</title>
</head>

<body>
    <!-- TODO Should not allow access to this if logged in already!-->
    <!-- Create basic header for login -->
    <section class="card-header text-center">
        <h1><a class="clean-link" href="HomeView.php">Ticketstubs</a></h1>
        <h2>Login Page</h2>
        <p class="lh-sm">Welcome to the login page!<br>Enter your login credentials below to log in.<br>Don't have an account yet? Register now!</p>
    </section>

    <section class="text-center">
        <!--Create the main login form, with a username and password -->
        <form method="POST" action="../Controllers/Auth.php" >
            <table class="mx-auto">
                <!-- Username -->
                <tr>
                    <td><label for="userTextbox">Username: </label></td>
                    <td><input class="my-2 ms-1" id="userTextbox" type="text" name="username" placeholder="Username"></td>
                </tr>
                <!-- Password -->
                <tr>
                    <td><label for="passTextbox">Password: </label></td>
                    <td><input class="my-2 ms-1" id="passTextbox" type="password" name="pass" placeholder="Password"></td>
                </tr>
            </table>


            <!--Two inputs for two different requests. Auth.php will handle the post request according to the name of the sender -->
            <input class="btn btn-primary my-2 logFormBtn" type="submit" name="login" value="Login">
            <input class="btn btn-secondary my-2 logFormBtn" type="submit" name="register" value="Register">

            <p class="text">Remember! Logging in overwrites the currently saved settings!</p>

            <?php
            // If the page is loaded with an error message, show it here according to the error id
            if(isset($_GET["eId"])) {
                if ($_GET["eId"] == 0) {
                    echo '<p class="text-danger">Please enter both a username and password.</p>';
                } else if($_GET["eId"] == 1) {
                    echo '<p class="text-danger">Entered username and/or password are invalid.</p>';
                } else if($_GET["eId"] == 2) {
                    echo "<p class='text-danger'>An unknown error has ocurred. Please contact a website administrator.</p>";
                } else if($_GET["eId"] == 3) {
                    echo "<p class='text-danger'>That username is already in use, please choose a different username.</p>";
                }
            } else if(isset($_GET["newReg"])) {
                //If the registration succeeded, show a confirmation message instead
                echo "<p class='text-info'>Account succesfully created!</p>";
            }

            ?>
        </form>
    </section>

