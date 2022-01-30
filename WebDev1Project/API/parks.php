<?php

try {
    echo "-2-";
    require_once $_SERVER['DOCUMENT_ROOT'] . 'BaseHTML/Models/Park.php';
    echo "-1-";
    require_once $_SERVER['DOCUMENT_ROOT'] . 'BaseHTML/Controllers/ParkController.php';
    echo "0";

    $controller = new ParkController();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo "1";
        $parks = $controller->GetAllParks();
        echo "2";
        $json = json_encode($parks);
        echo "3";
        header('Content-type:application/json; charset=utf-8');
        echo "4";
        echo $json;
    } else {
        echo "Invalid request type";
    }
} catch (Exception $e) {
    ?> <p> hi </p> <?php
}
?>