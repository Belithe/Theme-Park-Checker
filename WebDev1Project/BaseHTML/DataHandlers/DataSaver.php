<?php

include_once "DataLoader.php";
require_once("dbconfig.php");

class DataSaver {

    protected $SQLdb;
    protected $loader;

    function __construct() {
            // PDO instead of MySqli? Might not work on Heroku otherwise
            $dbConfig = getDBconfig();
            // Loader is created to create entries based on in-database info
            $this->loader = new DataLoader();
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

                $statement->bindParam(':parkId', $parkId);
                $statement->bindParam(':visited', $visited);

                $statement->execute();
            }
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    public function createNewVisitedSetting($userId=null, $parkId=null) {
        try {
            if ($userId != null && $parkId === null) {
                $parks = $this->loader->translateSelectAllParks();
                $query = 'INSERT INTO user_park_checks(parkId, userId, visited) VALUES';

                foreach ($parks as $park) {
                    $query .= ' (:' . $park['id'] . ', ' . $userId . ', false)';
                }

                $statement = $this->SQLdb->prepare($query);

                foreach ($parks as $park) {
                    $statement->bindParam(':' . $park['id'], $park['id']);
                }

                $statement->execute();
                return true;
            } else if ($parkId != null && $userId === null) {
                $users = $this->loader->translateSelectAllUserIds();
                $query = 'INSERT INTO user_park_checks(parkId, userId, visited) VALUES';

                foreach ($users as $id) {
                    $query .= ' (:' . $parkId . ', :' . $id['id'] . ', false)';
                }
                echo $query;
                $statement = $this->SQLdb->prepare($query);

                foreach ($users as $id) {
                    $statement->bindParam(':' . $parkId, $parkId);
                    $statement->bindParam(':' . $id['id'], $id['id']);
                }
                var_dump($statement);
                $statement->execute();
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }

}