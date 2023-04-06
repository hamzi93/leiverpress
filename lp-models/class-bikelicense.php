<?php

class BikeLicense{
    private $bl_id;
    private $bl_category;

    function __construct($id, $category){
        $this->setId($id);
        $this->setCategory($category);
    }

    static function getAllBikeLicenseFromJson(){
        require_once(MY_PLUGIN_PATH . 'lp-functions/model-functions.php');
        
        $bikeLicenseObjects = getFromJson(MY_PLUGIN_PATH . 'lp-data/bikelicense_data.json');
        $bikeLicenseCollection = array();
        foreach ($bikeLicenseObjects as $bikeLicense) {

            $bikeLicenseCollection[] = new BikeLicense($bikeLicense->bikelicense_id, $bikeLicense->bikelicense_category);
        }
        return $bikeLicenseCollection;
    }

    /**
     * Get the value of bl_id
     */
    function getId()
    {
        return $this->bl_id;
    }

    /**
     * Set the value of bl_id
     */
    function setId($bl_id): self
    {
        $this->bl_id = $bl_id;

        return $this;
    }

    /**
     * Get the value of bl_category
     */
    function getCategory()
    {
        return $this->bl_category;
    }

    /**
     * Set the value of bl_category
     */
    function setCategory($bl_category): self
    {
        $this->bl_category = $bl_category;

        return $this;
    }
}