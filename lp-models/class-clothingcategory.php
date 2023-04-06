<?php

class ClothingCategory{

    private $cc_id;
    private $cc_name;

    function __construct($clothingCategory_id, $clothingCategory_name){
        $this->setId($clothingCategory_id);
        $this->setName($clothingCategory_name);
    }

    static function getAllClothingCategoryFromJson(){
        require_once(MY_PLUGIN_PATH . 'lp-functions/model-functions.php');
        
        $clothingCategoryObjects = getFromJson(MY_PLUGIN_PATH . 'lp-data/clothingcategory_data.json');
        $clothingCategoryCollection = array();
        foreach ($clothingCategoryObjects as $clothingCategory) {

            $clothingCategoryCollection[] = new ClothingCategory($clothingCategory->clothingcategory_id, $clothingCategory->clothingcategory_name);
        }
        return $clothingCategoryCollection;
    }

    /**
     * Get the value of cc_id
     */
    function getId()
    {
        return $this->cc_id;
    }

    /**
     * Set the value of cc_id
     */
    function setId($cc_id): self
    {
        $this->cc_id = $cc_id;

        return $this;
    }

    /**
     * Get the value of cc_name
     */
    function getName()
    {
        return $this->cc_name;
    }

    /**
     * Set the value of cc_name
     */
    function setName($cc_name): self
    {
        $this->cc_name = $cc_name;

        return $this;
    }
}