<?php

try {
    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/BaseHTML/Models/Park.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/BaseHTML/Controllers/ParkController.php';

    $controller = new ParkController();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $parks = $controller->GetAllParks();
        $json = json_encode($parks);
        header('Content-type:application/json; charset=utf-8');
        echo $json;
    } else {
        echo "Invalid request type";
    }
} catch (Exception $e) {
    ?> <p> hi </p> <?php
}
?>