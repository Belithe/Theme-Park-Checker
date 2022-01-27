<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require 'dbconfig.php';

try {
    $dbConfig = getDBconfig();
    $conn = new PDO("$dbConfig[4]:host=$dbConfig[0];dbname=$dbConfig[3]", $dbConfig[1], $dbConfig[2]);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Failure: " . $e->getMessage();
}

try {
    $conn->query("CREATE TABLE park (
    id int(2) NOT NULL AUTO_INCREMENT,
    name varchar(50) NOT NULL,
    type varchar(30) NOT NULL,
    province varchar(20) NOT NULL,
     PRIMARY KEY (id)
    ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4");

    $conn->query("CREATE TABLE info (
    parkId int(2) NOT NULL,
    info varchar(150) NOT NULL,
    exLink varchar(50) NOT NULL,
    PRIMARY KEY (parkId),
    CONSTRAINT infoToPark FOREIGN KEY (parkId) REFERENCES park (id) ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $conn->query("CREATE TABLE user (
     id int(2) NOT NULL AUTO_INCREMENT,
     username varchar(255) NOT NULL,
     password varchar(255) NOT NULL,
     PRIMARY KEY (id)
    ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4");

    $conn->query("CREATE TABLE user_park_checks (
     parkId int(11) NOT NULL,
     userId int(11) NOT NULL,
     visited tinyint(1) NOT NULL DEFAULT 0,
     PRIMARY KEY (parkId,userId),
     KEY userId (userId),
     CONSTRAINT parkId FOREIGN KEY (parkId) REFERENCES park (id) ON DELETE CASCADE ON UPDATE CASCADE,
     CONSTRAINT userId FOREIGN KEY (userId) REFERENCES user (id) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");



} catch (PDOException $e) {
    echo "Failure2: " . $e->getMessage();
}

try {
    $conn->query("INSERT INTO park ('name', 'type', 'province') 
    VALUES ('Archeon', 'Experience Park', 'Zuid-Holland'), 
           ('Attractiepark Slagharen', 'Themepark', 'Overijssel')");

    $conn->query("INSERT INTO info ('parkId', 'info', 'exLink') 
    VALUES (3, 'Testing info!', 'www.testlink.com'), 
           (4, 'Testing info 2!', 'www.testlink2.com') ");

    $conn->query("INSERT INTO user ('username', 'password') 
    VALUES ('bear', '550a6aee24871befa055ffd52f92eba9'), 
           ('cow', 'c9507f538a6e79c9bd6229981d6e05a3')");

    $conn->query("INSERT INTO user_park_checks ('parkId', 'userId', 'visited') 
    VALUES (3, 2, 1), 
           (4, 2, 1)");

} catch (PDOException $e) {
    //echo "Failure3: " . $e->getMessage();
}