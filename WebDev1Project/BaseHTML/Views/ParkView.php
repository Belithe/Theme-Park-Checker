<!DOCTYPE html>
<head title="Ticketstubs">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/manualStyle.css">
    <script src="/js/manualScript.js"></script>
    <title>Ticketstubs</title>
</head>

<?php
    //load need controllers, start the session

    include $_SERVER['DOCUMENT_ROOT'] . '/BaseHTML/Controllers/InfoController.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/BaseHTML/Controllers/ParkController.php';

    session_start();
    $InfoController = new InfoController();
    $ParkController = new ParkController();
?>
<body>

    <!--Create basic header -->
    <section class="card-header text-center">
        <h1><a class="clean-link" href="HomeView.php">Ticketstubs</a></h1>
    <?php
    //If given a parkid is given like it should be, continue
    if($ParkController->currentByIdPark != null) { ?>
            <h2><?php  $ParkController->showLoadedParkName();?></h2>
            <p class="lh-sm"></p>
            <a href="LoginView.php">
                <button type="button" class="btn btn-primary"> Login!</button>
            </a>
            </section>

        <p class="text-center">
            <?php $InfoController->showLoadedInfo();?>
            <br>
            <?php $ParkController->showLoadedParkType(); ?>
        </p>
    <?php } else {
        //Create a warning page if the parkview page was accessed without a parkId
        ?>
        <h2>Error 404!</h2>
        </section>
        <p class="text-center">Oh no! Unfortunately, this page does not exist. Please return the home menu.</p>
    <?php } ?>


</body>