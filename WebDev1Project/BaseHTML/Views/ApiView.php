<head title="Ticketstubs">
    <link rel="stylesheet" href=<?php echo $_SERVER['DOCUMENT_ROOT'] . '/css/bootstrap.css'?>>
    <link rel="stylesheet" href=<?php echo $_SERVER['DOCUMENT_ROOT'] . '/css/manualStyle.css'?>>
    <script src=<?php echo $_SERVER['DOCUMENT_ROOT'] . '/js/manualScript.js'?>></script>
    <title>Ticketstubs</title>
</head>

<?php

?>

<section class="card-header text-center">
    <h1><a class="clean-link" href="HomeView.php">Ticketstubs</a></h1>
    <h2>API Page</h2>
    <p class="lh-sm">Welcome to the API view page.<br>The /API/parks.php endpoint is sent a GET request.<br>This is merely a showcase of the API.</p>
</section>


<?php
    $url = "https://theme-park-checker.herokuapp.com/API/parks.php";

    $client = curl_init($url);
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    $jsonData = curl_exec($client);

    $apiData = json_decode($jsonData, true);
?>

    <?php
    foreach($apiData as $entry) {
        ?> <p>  <?php echo '"id:"' . $entry['id']; ?> <br>
                <?php echo '"name:"' . $entry['name'] ?> <br>
                <?php echo '"type:"' . $entry['type'] ?> <br>
                <?php echo '"province:"' . $entry['province'] ?> <br> <?php
    }

    ?>

