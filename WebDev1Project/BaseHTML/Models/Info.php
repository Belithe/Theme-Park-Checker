<?php

class Info
{
    private $parkId;
    private $info;
    private $exLink;

    function __construct($givenId, $givenInfo, $givenExLink) {
        $this->parkId = $givenId;
        $this->info = $givenInfo;
        $this->exLink = $givenExLink;
    }

    //external link getter/setter
    public function getExLink()
    {
        return $this->exLink;
    }

    public function setExLink($exLink)
    {
        $this->exLink = $exLink;
    }

    //info getter/setter
    public function getInfo()
    {
        return $this->info;
    }
    public function setInfo($info)
    {
        $this->info = $info;
    }

    //id getter
    public function getParkId()
    {
        return $this->parkId;
    }


}