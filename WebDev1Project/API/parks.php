<?php

header("Content-Type:application/json");

require "../BaseHTML/Models/Park.php";
require "../BaseHTML/Controllers/ParkController.php";

$controller = new ParkController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    SendResponse(200, "List of parks found.", $controller->GetAllParks());

}

function SendResponse($statusCode, $statusMsg, $data) {
    header("HTTP/1.1 " . $statusCode);

    $response['status'] = $statusCode;
    $response['status-message'] = $statusMsg;
    $response['data'] = $data;

    $json = json_encode($response);
    echo $json;
}


?>