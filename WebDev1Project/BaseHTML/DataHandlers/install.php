<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require 'dbconfig.php';

try {
    $dbConfig = getDBconfig();
    $conn = new PDO("$dbConfig[4]:host=$dbConfig[0];dbname=$dbConfig[3]", $dbConfig[1], $dbConfig[2]);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo $dbConfig[4];
} catch (PDOException $e) {
    echo "Failure: " . $e->getMessage();
}

try {
    /*$conn->query("CREATE TABLE park (
    id SERIAL NOT NULL,
    name varchar(50) NOT NULL,
    type varchar(30) NOT NULL,
    province varchar(20) NOT NULL,
     PRIMARY KEY (id)
    )");

    $conn->query("CREATE TABLE info (
    parkId int NOT NULL,
    info varchar(150) NOT NULL,
    exLink varchar(50) NOT NULL,
    PRIMARY KEY (parkId),
    CONSTRAINT infoToPark FOREIGN KEY (parkId) REFERENCES park (id) ON UPDATE CASCADE
    )");*/

    $conn->query("CREATE TABLE users (
     id SERIAL NOT NULL,
     username varchar(255) NOT NULL,
     password varchar(255) NOT NULL,
     PRIMARY KEY (id)
    )");

    $conn->query("CREATE TABLE user_park_checks (
     parkId int NOT NULL,
     userId int NOT NULL,
     visited bool NOT NULL DEFAULT false,
     PRIMARY KEY (parkId,userId),
     CONSTRAINT parkId FOREIGN KEY (parkId) REFERENCES park (id) ON DELETE CASCADE ON UPDATE CASCADE,
     CONSTRAINT userId FOREIGN KEY (userId) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
    )");



} catch (PDOException $e) {
    echo "Failure2: " . $e->getMessage();
}

try {
    /*$conn->query("INSERT INTO park (name, type, province)
    VALUES ('Archeon', 'Experience Park', 'Zuid-Holland'), 
           ('Attractiepark Slagharen', 'Themepark', 'Overijssel')");

    $conn->query("INSERT INTO info (parkId, info, exLink) 
    VALUES (1, 'Testing info!', 'www.testlink.com'), 
           (2, 'Testing info 2!', 'www.testlink2.com') ");*/

    $conn->query("INSERT INTO users (username, password) 
    VALUES ('bear', '550a6aee24871befa055ffd52f92eba9'), 
           ('cow', 'c9507f538a6e79c9bd6229981d6e05a3')");

    $conn->query("INSERT INTO user_park_checks (parkId, userId, visited) 
    VALUES (3, 2, true), 
           (4, 2, true)");

} catch (PDOException $e) {
    //echo "Failure3: " . $e->getMessage();
}