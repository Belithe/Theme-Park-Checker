<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'BaseHTML/Models/Park.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'BaseHTML/DataHandlers/DataLoader.php';


class ParkController {

    //Create the database handler and the loaded park variable
    protected $loader;
    public $currentByIdPark;

    function __construct() {
        $this->loader = new DataLoader();

        if(!isset($_SESSION['checked'])) {
            $this->fillSessionChecked();
        }

        //Check if a park is loaded, if so, create a park to save as the currently loaded one
        if(isset($_GET["id"]) && $_GET["id"] != "") {
            foreach($this->loader->translateParkByIdData() as $attribute){
                $loadedId = $attribute['id'];
                $loadedName = $attribute['name'];
                $loadedType = $attribute['type'];
                $loadedProvince = $attribute['province'];

                $this->currentByIdPark = new Park($loadedId, $loadedName, $loadedType, $loadedProvince);
            }

        }
    }

    public function GetAllParks() {

        foreach($this->loader->translateSelectAllParks() as $entry) {
                $parkToAdd = new Park($entry['id'], $entry['name'], $entry['type'], $entry['province']);
                $parks[$entry['id']] = $parkToAdd;
        }

        return $parks;
    }

    // Fill session checked array
    public function fillSessionChecked() {
        foreach ($this->GetAllParks() as $entry) {
            //create an entry in the `checked` session variable for each park
            $_SESSION['checked'][$entry->getId() . 'Checker'] = 0;
        }
    }

    // Show variables in a view if requested
    public function showLoadedParkName() {
        echo $this->currentByIdPark->getName();
    }

    public function showLoadedParkType() {
        echo $this->currentByIdPark->getType();
    }

    public function showLoadedParkProvince() {
        echo $this->currentByIdPark->getProvince();
    }

    //Creation of the main table on the home page
    public function insertParkData() {

        //Load the saved parks from DB and create a table row for it
        foreach ($this->GetAllParks() as $entry) {

            //Check if the session has checked the park's visited column, and set the variable for this
            $entryChecked = "";

            if($_SESSION['checked'][$entry->getId() . 'Checker'] == 1) {
                $entryChecked = "checked";
            }

            //Creating the row as a long string to echo
            $rowToInsert = "<tr>";
            //Load variables from database entry
            $rowToInsert .= '<td>' . $entry->getName() . '</td>';
            $rowToInsert .= '<td>' . $entry->getType() . '</td>';
            $rowToInsert .= '<td>' . $entry->getProvince() . '</td>';
            //Create a link to Parkview with the matching park id
            $rowToInsert .= '<td> <a href="../Views/ParkView.php?id='. $entry->getId() . '">' . $entry->getName() . ' Info </a>' . '</td>';
            //Create checking input, pre-checked according to the entryChecked value
            $rowToInsert .= '<td><input class="form-check-input" type="checkbox" name="' . $entry->getId() . 'Checker" value="" '. $entryChecked . '></td>';

            //Insert the row
            echo $rowToInsert;
        }
    }
}


?>