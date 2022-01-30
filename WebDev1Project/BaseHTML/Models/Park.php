<?php

class Park implements \JsonSerializable
{
    private $id;
    private $name;
    private $type;
    private $province;

    function __construct($givenId, $givenName, $givenType, $givenProvince) {
        $this->id = $givenId;
        $this->name = $givenName;
        $this->type = $givenType;
        $this->province = $givenProvince;
    }

    function jsonSerialize()
    {
        return get_object_vars($this);
    }

    // ID getter

    public function getId()
    {
        return $this->id;
    }

    //Name getter/setter
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    //Province getter/setter
    public function getProvince()
    {
        return $this->province;
    }

    public function setProvince($province)
    {
        $this->province = $province;
    }

    //Type getter/setter
    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }
}