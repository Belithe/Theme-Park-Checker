<head title="Ticketstubs">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../css/manualStyle.css">
    <script src="../../js/manualScript.js"></script>
    <title>Ticketstubs</title>
</head>

<?php

?>

<section class="card-header text-center">
    <h1><a class="clean-link" href="HomeView.php">Ticketstubs</a></h1>
    <h2>Login Page</h2>
    <p class="lh-sm">Welcome to the login page!<br>Enter your login credentials below to log in.<br>Don't have an account yet? Register now!</p>
</section>


<?php
    $url = "https://theme-park-checker.herokuapp.com/API/parks.php";

    $client = curl_init($url);
    //curl_setopt($client, )
?>