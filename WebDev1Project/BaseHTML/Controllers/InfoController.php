<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/WebDev1Project/BaseHTML/Models/Info.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/WebDev1Project/BaseHTML/DataHandlers/DataLoader.php';

class InfoController {

    protected $currentByIdInfo;
    protected $loader;

    function __construct() {
        $this->loader = new DataLoader();

        //Get info from db matching the given GET id
        if(isset($_GET["id"]) && $_GET["id"] != "") {
            foreach($this->loader->translateInfoByIdData() as $attribute){
                 $loadedInfo = $attribute['info'];
                 $loadedExLink = $attribute['exLink'];
                 $loadedId = $attribute['parkId'];
            }

            $this->currentByIdInfo = new Info($loadedId, $loadedInfo, $loadedExLink);
        }
    }

    //Show variables in view when requested
    public function showLoadedInfo() {
        echo $this->currentByIdInfo->getInfo();
    }

}


?>