<?php

require_once("dbconfig.php");

class DataLoader {

    protected $SQLdb;


    function __construct() {
        // PDO instead of MySqli? Might not work on Heroku otherwise TODO
        $dbConfig = getDBconfig();
        //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        //$this->SQLdb = new mysqli('localhost', 'test', 'hackerman', 'themeparkdb');
        $this->SQLdb = new PDO("$dbConfig[4]:host=$dbConfig[0];dbname=$dbConfig[3]", $dbConfig[1], $dbConfig[2]);
    }


    //Select statement requests
    //Select all parks
    private function selectParks() {
        $statement = $this->SQLdb->prepare('SELECT * FROM `park`');

        $statement->execute();
        return $statement;

        //$selectAllQuery = "SELECT * FROM `park` ";
        //return mysqli_query($this->SQLdb, $selectAllQuery);
    }

    //select park from a get variable (Maybe change to given variable? TODO)
    private function selectParkById() {
        $requestedId = htmlspecialchars($_GET["id"]);

        $statement = $this->SQLdb->prepare('SELECT * FROM `park` WHERE `id` = :id');
        $statement->bindParam(':id', $requestedId);

        $statement->execute();
        return $statement;

        //$selectParkDataByParkId = "SELECT * FROM `park` WHERE `id` = " . $requestedId;
    }

    //select info from a get variable (Maybe change to given variable, too? TODO)
    private function selectInfoById() {
        $requestedId = htmlspecialchars($_GET["id"]);

        $statement = $this->SQLdb->prepare('SELECT * FROM `info` WHERE `parkId` = :id');
        $statement->bindParam(':id', $requestedId);

        $statement->execute();
        return $statement;

        //$selectInfoByParkId = "SELECT * FROM `info` WHERE `parkId` = " . $requestedId;

    }

    //Select a user matching the given username
    private function selectMatchingUser($username) {
        $statement = $this->SQLdb->prepare('SELECT * FROM `user` WHERE `username` = :name');
        if(!empty($statement)) {
            $statement->bindParam(':name', $username);

            $statement->execute();
            return $statement;
        } else {
            return false;
        }
    }

    //Select visited settings from the given user id
    private function getVisitedSettings($userId) {
        $requestedId = htmlspecialchars($userId);

        $statement = $this->SQLdb->prepare('SELECT * FROM `user_park_checks` WHERE `userId` = :id');
        $statement->bindParam(':id', $requestedId);

        $statement->execute();
        return $statement;
    }



    //translate any data returned by select statements, seperate for easier editing if needed
    public function translateSelectAllParks() {
        return $this->selectParks()->fetchAll();

    }

    public function translateParkByIdData() {
        return $this->selectParkById()->fetchAll();
    }

    public function translateInfoByIdData() {
        return $this->selectInfoById()->fetchAll();

    }

    public function translateSelectMatchingUser($username) {
        return $this->selectMatchingUser($username)->fetchAll();
    }

    public function translateGetVisitedSettings($userId) {
        return $this->getVisitedSettings($userId)->fetchAll();
    }
}

?>