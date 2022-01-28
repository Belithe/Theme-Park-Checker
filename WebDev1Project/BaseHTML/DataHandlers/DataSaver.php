<?php

require_once("dbconfig.php");

class DataSaver {

    protected $SQLdb;

    function __construct() {
            // PDO instead of MySqli? Might not work on Heroku otherwise
            $dbConfig = getDBconfig();
            //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            //$this->SQLdb = new mysqli('localhost', 'test', 'hackerman', 'themeparkdb');
            $this->SQLdb = new PDO("$dbConfig[4]:host=$dbConfig[0];dbname=$dbConfig[3]", $dbConfig[1], $dbConfig[2]);

    }

    //Insert or update requests
    //Create a new user with the given username and password, ID is auto generated
    public function createNewUser($username, $password) {
        try {
            $statement = $this->SQLdb->prepare('INSERT INTO users (username, password) VALUES (:name, :pass)');
            $statement->bindParam(':name', $username);
            $statement->bindParam(':pass', $password);

            $statement->execute();
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    //Create or update user's visited park entries
    public function saveVisitedSettings($userId, $checked) {
        try {
            $statement = $this->SQLdb->prepare('INSERT INTO user_park_checks (parkId, userId, visited) VALUES (:parkId, :userId, :visited) ON CONFLICT (parkId, userId) DO UPDATE SET visited = :visited');

            $statement->bindParam(':userId', $userId);

            foreach($checked as $key => $bool) {
                $parkId = substr($key, 0, 1);
                $visited = "false";
                if($bool == 1) {
                    $visited = "true";
                }

                echo "P:" . $parkId;
                echo "V:" . $visited;
                echo "B:" . $bool;

                $statement->bindParam(':parkId', $parkId);
                $statement->bindParam(':visited', $visited);

                $statement->execute();
            }
            return true;
        } catch(Exception $e) {
            return false;
        }
    }
}