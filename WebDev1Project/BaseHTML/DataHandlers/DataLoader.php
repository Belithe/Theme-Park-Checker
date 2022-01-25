<?php

class DataLoader {

    protected $SQLdb;

    function __construct() {
        // PDO instead of MySqli? Might not work on Heroku otherwise TODO
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->SQLdb = new mysqli('localhost', 'test', 'hackerman', 'themeparkdb');
    }


    //Select statement requests
    //Select all parks
    private function selectParks() {
        $statement = $this->SQLdb->prepare('SELECT * FROM `park`');

        $statement->execute();
        return $statement->get_result();

        //$selectAllQuery = "SELECT * FROM `park` ";
        //return mysqli_query($this->SQLdb, $selectAllQuery);
    }

    //select park from a get variable (Maybe change to given variable? TODO)
    private function selectParkById() {
        $requestedId = htmlspecialchars($_GET["id"]);

        $statement = $this->SQLdb->prepare('SELECT * FROM `park` WHERE `id` = ?');
        $statement->bind_param('s', $requestedId);

        $statement->execute();
        return $statement->get_result();

        //$selectParkDataByParkId = "SELECT * FROM `park` WHERE `id` = " . $requestedId;
    }

    //select info from a get variable (Maybe change to given variable, too? TODO)
    private function selectInfoById() {
        $requestedId = htmlspecialchars($_GET["id"]);

        $statement = $this->SQLdb->prepare('SELECT * FROM `info` WHERE `parkId` = ?');
        $statement->bind_param('s', $requestedId);

        $statement->execute();
        return $statement->get_result();

        //$selectInfoByParkId = "SELECT * FROM `info` WHERE `parkId` = " . $requestedId;

    }

    //Select a user matching the given username
    private function selectMatchingUser($username) {
        $statement = $this->SQLdb->prepare('SELECT * FROM `user` WHERE `username` = ?');
        if(!empty($statement)) {
            $statement->bind_param('s', $username);

            $statement->execute();
            return $statement->get_result();
        } else {
            return false;
        }
    }

    //Select visited settings from the given user id
    private function getVisitedSettings($userId) {
        $requestedId = htmlspecialchars($userId);

        $statement = $this->SQLdb->prepare('SELECT * FROM `user_park_checks` WHERE `userId` = ?');
        $statement->bind_param('s', $requestedId);

        $statement->execute();
        return $statement->get_result();
    }



    //translate any data returned by select statements, seperate for easier editing if needed
    public function translateSelectAllParks() {
        return mysqli_fetch_all($this->selectParks(), MYSQLI_ASSOC);

    }

    public function translateParkByIdData() {
        return mysqli_fetch_all($this->selectParkById(), MYSQLI_ASSOC);
    }

    public function translateInfoByIdData() {
        return mysqli_fetch_all($this->selectInfoById(), MYSQLI_ASSOC);

    }

    public function translateSelectMatchingUser($username) {
        return mysqli_fetch_all($this->selectMatchingUser($username), MYSQLI_ASSOC);
    }

    public function translateGetVisitedSettings($userId) {
        return mysqli_fetch_all($this->getVisitedSettings($userId), MYSQLI_ASSOC);
    }
}

?>