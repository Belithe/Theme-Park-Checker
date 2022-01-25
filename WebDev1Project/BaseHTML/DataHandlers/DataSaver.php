<?php

class DataSaver {

    function __construct() {
        // PDO instead of MySqli? Might not work on Heroku otherwise TODO
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->SQLdb = new mysqli('localhost', 'test', 'hackerman', 'themeparkdb');
    }

    //Insert or update requests
    //Create a new user with the given username and password, ID is auto generated
    public function createNewUser($username, $password) {
        try {
            $statement = $this->SQLdb->prepare('INSERT INTO `user` (`username`, `password`) VALUES (?,?)');
            $statement->bind_param('ss', $username, $password);

            $statement->execute();
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    //Create or update user's visited park entries
    public function saveVisitedSettings($userId, $checked) {
        try {
            $statement = $this->SQLdb->prepare('INSERT INTO `user_park_checks` (`parkId`, `userId`, `visited`) VALUES (?,?,?) ON DUPLICATE KEY UPDATE `visited` = ?');
            $statement->bind_param('iiii', $parkId, $userId, $visited, $visited);

            foreach($checked as $key => $bool) {
                $parkId = substr($key, 0, 1);
                $visited = $bool;

                $statement->execute();
            }
            return true;
        } catch(Exception $e) {
            return false;
        }
    }
}