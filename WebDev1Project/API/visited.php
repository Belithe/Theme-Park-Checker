
<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT'] . '/BaseHTML/Models/Park.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/BaseHTML/Controllers/ParkController.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/BaseHTML/DataHandlers/DataSaver.php';

    $controller = new ParkController();
    $saver = new DataSaver();

    if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['user'])) {
        $userId = $_GET['user'];
        $sentJSON = 'php://input';

        $newJSON = json_decode($sentJSON, true);
        $saver->saveVisitedSettings($sentJSON['id'], $sentJSON['checked']);
    } else {
        echo "Invalid request type";
    }
} catch (Exception $e) {
    ?>  <?php
}
?>