<?php


require "../BaseHTML/Models/Park.php";
require "../BaseHTML/Controllers/ParkController.php";

$controller = new ParkController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    SendResponse(200, "List of parks found.", $controller->GetAllParks());

} else {
    SendResponse(405, "Invalid request type.", null);
}

function SendResponse($statusCode, $statusMsg, $data) {
    $response['status'] = $statusCode;
    $response['status-message'] = $statusMsg;
    $response['data'] = $data;

    $json = json_encode($response);
    header('Content-type:application/json; charset=utf-8');
    echo $json;
}


?>