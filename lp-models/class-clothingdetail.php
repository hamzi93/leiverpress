<?php

class ClothingDetail{

    private $cd_id;
    private $cd_name;
    private $cd_image;
    private $cd_description;
    private $cc_id;

    function __construct($clothingDetail_id, $clothingDetail_name, $clothingDetail_image, $clothingDetail_description, $clothingCategory_id){
        $this->setId($clothingDetail_id);
        $this->setName($clothingDetail_name);
        $this->setImage($clothingDetail_image);
        $this->setDescription($clothingDetail_description);
        $this->setCcId($clothingCategory_id);
    }

    static function getAllClothingDetailFromJson(){
        require_once(MY_PLUGIN_PATH . 'lp-functions/model-functions.php');
        
        $clothingDetailObjects = getFromJson(MY_PLUGIN_PATH . 'lp-data/clothingdetail_data.json');
        $clothingDetailCollection = array();
        foreach ($clothingDetailObjects as $clothingDetail) {

            $clothingDetailCollection[] = new ClothingDetail($clothingDetail->clothingdetail_id, $clothingDetail->clothingdetail_name, $clothingDetail->clothingdetail_image, $clothingDetail->clothingdetail_description ,$clothingDetail->clothingcategory_id);
        }
        return $clothingDetailCollection;
    }


    /**
     * Get the value of cd_id
     */
    function getId()
    {
        return $this->cd_id;
    }

    /**
     * Set the value of cd_id
     */
    function setId($cd_id): self
    {
        $this->cd_id = $cd_id;

        return $this;
    }

    /**
     * Get the value of cd_name
     */
    function getName()
    {
        return $this->cd_name;
    }

    /**
     * Set the value of cd_name
     */
    function setName($cd_name): self
    {
        $this->cd_name = $cd_name;

        return $this;
    }

    /**
     * Get the value of cd_image
     */
    function getImage()
    {
        return $this->cd_image;
    }

    /**
     * Set the value of cd_image
     */
    function setImage($cd_image): self
    {
        $this->cd_image = $cd_image;

        return $this;
    }

    /**
     * Get the value of cc_id
     */
    function getCcId()
    {
        return $this->cc_id;
    }

    /**
     * Set the value of cc_id
     */
    function setCcId($cc_id): self
    {
        $this->cc_id = $cc_id;

        return $this;
    }

    /**
     * Get the value of cd_description
     */
    function getDescription()
    {
        return $this->cd_description;
    }

    /**
     * Set the value of cd_description
     */
    function setDescription($cd_description): self
    {
        $this->cd_description = $cd_description;

        return $this;
    }
}