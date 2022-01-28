<?php

require_once '../Models/Park.php';
require_once '../DataHandlers/DataLoader.php';


class ParkController {

    //Create the database handler and the loaded park variable
    protected $loader;
    public $currentByIdPark;

    function __construct() {
        $this->loader = new DataLoader();

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
        foreach ($this->loader->translateSelectAllParks() as $entry) {

            //Check if the session has checked the park's visited column, and set the variable for this
            $entryChecked = "";

            if($_SESSION['checked'][$entry['id'] . 'Checker'] == true) {
                $entryChecked = "checked";
            }
            echo $_SESSION['checked'][$entry['id'] . 'Checker'];

            //Creating the row as a long string to echo
            $rowToInsert = "<tr>";
            //Load variables from database entry
            $rowToInsert .= '<td>' . $entry['name'] . '</td>';
            $rowToInsert .= '<td>' . $entry['type'] . '</td>';
            $rowToInsert .= '<td>' . $entry['province'] . '</td>';
            //Create a link to Parkview with the matching park id
            $rowToInsert .= '<td> <a href="../Views/ParkView.php?id='. $entry["id"] . '">' . $entry['name'] . ' Info </a>' . '</td>';
            //Create checking input, pre-checked according to the entryChecked value
            $rowToInsert .= '<td><input class="form-check-input" type="checkbox" name="' . $entry['id'] . 'Checker" value="" '. $entryChecked . '></td>';

            //Insert the row
            echo $rowToInsert;
        }
    }
}


?>