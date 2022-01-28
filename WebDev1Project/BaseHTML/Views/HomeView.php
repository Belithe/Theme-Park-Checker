
<head title="Ticketstubs">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../css/manualStyle.css">
    <script src="../../js/manualScript.js"></script>
    <title>Ticketstubs</title>
</head>

<?php
    //load necessary controllers and start session

    include '../Controllers/ParkController.php';
    include '../Controllers/UserController.php';

    session_start();

    $ParkController = new ParkController();
    $UserController = new UserController();

    //Check if save post request is made, if so try to do so and report success or failure
    $success = false;

    print_r($_POST);

    if(!empty($_POST["Save"])) {
        print_r($success);
        $success = $UserController->SaveCurrentSession();
        print_r($success);
    }

?>

<body>
<!--Create basic header -->
<section class="card-header text-center">
    <h1><a class="clean-link" href="HomeView.php">Ticketstubs</a></h1>
    <h2>Main Page</h2>
    <p class="lh-sm">Welcome to ParkChecker!<br>Login below to track the parks you have visited!</p>
    <a href="LoginView.php">
        <button type="button" class="btn btn-primary"> Login!</button>
    </a>
</section>

<!--Create form with table with as many rows as needed, generation of rows handled by Park Controller, sends save post request to self to handle at top  -->
<section class="text-center">
    <form method="POST" target="_self">
        <table id="mainTable" class="table table-bordered table-responsive-sm table-striped ">
            <tr>
                <td class="fw-bold">Name</td>
                <td class="fw-bold">Type</td>
                <td class="fw-bold">Province</td>
                <td class="fw-bold">Info Page Link</td>
                <td class="fw-bold">Visited?</td>
            </tr>
            <?php
                $ParkController->insertParkData();
            ?>

        </table>
        <input type="submit" value="Save" name="Save" class="btn btn-secondary shadow-sm mt-md-3"/>
        <?php
        //if the error id is set, generate error message, currently unused? TODO
        if(isset($_GET['eId'])) {
            if ($_GET['eId'] == 4) {
                echo "<p class='text-danger'>Please mark at least one visited park.</p>";
            }
        }
        ?>
    </form>
</section>

<!--Create confirmation popup, but hide it with manualStyle css -->
<section id="confirmPopup" class="alert alert-success ms-lg-3 position-absolute bottom-0 shadow-sm">
    <p>Data saved!</p>
</section>

</body>


<?php

//If data save was succesful earlier, show above popup, then hide it again
if ($success) {
    echo "<script>handlePopUp()</script>";
} ?>


</script>



