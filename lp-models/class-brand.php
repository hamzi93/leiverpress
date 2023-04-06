<?php

class Brand
{
    private $br_id;
    private $br_name;

    function __construct($id, $name){
        $this->setId($id);
        $this->setName($name);
    }

    function equals_brand($newBrand){
        if($this->br_name == strtoupper($newBrand)){
            return false;
        }
        return true;
    }

    static function getAllBrandsFromJson(){
        require_once(MY_PLUGIN_PATH . 'lp-functions/model-functions.php');
        
        $brandObjects = getFromJson(MY_PLUGIN_PATH . 'lp-data/brand_data.json');
        $bikeCollection = array();
        
        foreach ($brandObjects as $brand) {
            $bikeCollection[] = new Brand($brand->brand_id, $brand->brand_name);
        }
        return $bikeCollection;
    }

    static function getAllBrands()
    {
        global $wpdb;
        //tablename so angegeben, weil wpdb->bike nicht funktioniert
        $tableName = $wpdb->prefix . 'brand';

        $brands = $wpdb->get_results("SELECT * FROM $tableName ORDER BY brand_id");
        //$brandsCollection = array();
        foreach ($brands as $brand) {
            $brandsCollection[] = new Brand($brand->brand_id, $brand->brand_name);
        }
        return $brandsCollection;
    }

    static function getBrandIdByName($brandName) {
        global $wpdb;
        $tableName = $wpdb->prefix . 'brand';
    
        // Holt sich die ID der Marke nach dem Namen des Bikes raus. (Abgesichert durch %s)
        $query = $wpdb->prepare("SELECT brand_id FROM $tableName WHERE brand_name = %s", $brandName);
    
        $brand = $wpdb->get_results($query);
    
        if (!empty($brand)) {
            return intval($brand[0]->brand_id);
        } else {
            throw new Exception("Die gewünschte Marke konnte nicht gefunden werden!");
        }
    }

    /**
     * Get the value of id
     */
    function getId()
    {
        return $this->br_id;
    }

    /**
     * Set the value of id
     */
    function setId($id): self
    {
        $this->br_id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */
    function getName()
    {
        return $this->br_name;
    }

    /**
     * Set the value of name
     */
    function setName($name): self
    {
        if(strlen($name) < 31){
            $this->br_name = strtoupper($name);
        }else{
            $this->br_name = '';
        }
        return $this;
    }
}