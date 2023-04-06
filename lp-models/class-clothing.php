<?php

class Clothing{

    private $c_id;
    private $c_size;
    private $cd_id; //clothing detail

    function __construct($clothing_id, $clothing_size, $clothingDetail_id){
        $this->setId($clothing_id);
        $this->setSize($clothing_size);
        $this->setCdId($clothingDetail_id);
    }

    static function getAllClothingFromJson(){
        require_once(MY_PLUGIN_PATH . 'lp-functions/model-functions.php');
        
        $clothingObjects = getFromJson(MY_PLUGIN_PATH . 'lp-data/clothing_data.json');
        $clothingCollection = array();
        foreach ($clothingObjects as $clothing) {

            $clothingCollection[] = new Clothing($clothing->clothing_id, $clothing->clothing_size, $clothing->clothingdetail_id);
        }
        return $clothingCollection;
    }

    /**
     * Get the value of c_id
     */
    function getId()
    {
        return $this->c_id;
    }

    /**
     * Set the value of c_id
     */
    function setId($c_id): self
    {
        $this->c_id = $c_id;

        return $this;
    }

    /**
     * Get the value of c_size
     */
    function getSize()
    {
        return $this->c_size;
    }

    /**
     * Set the value of c_size
     */
    function setSize($c_size): self
    {
        $this->c_size = $c_size;

        return $this;
    }

    /**
     * Get the value of cd_id
     */
    function getCdId()
    {
        return $this->cd_id;
    }

    /**
     * Set the value of cd_id
     */
    function setCdId($cd_id): self
    {
        $this->cd_id = $cd_id;

        return $this;
    }
}