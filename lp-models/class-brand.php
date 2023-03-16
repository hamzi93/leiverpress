<?php

class Brand
{
    private $id;
    private $name;

    function __construct($id, string $name){
        $this->setId($id);
        $this->setName($name);
    }

    function equals_brand($newBrand){
        if($this->name == strtoupper($newBrand)){
            return false;
        }
        return true;
    }

    public static function getAllBrandsFromJson(){
        $brandString = file_get_contents(MY_PLUGIN_PATH . 'lp-data/brand_data.json');
        if($brandString === false){
            return null;
        }
        $brandObjects = json_decode($brandString);
        $bikeCollection = array();
        foreach ($brandObjects as $brand) {
            
            $bikeCollection[] = new Brand($brand->brand_id, $brand->brand_name);
        }
        return $bikeCollection;
    }

    public static function getAllBrands()
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

    public static function getBrandIdByName($brand_name) {
        global $wpdb;
        $tableName = $wpdb->prefix . 'brand';
    
        // Holt sich die ID der Marke nach dem Namen des Bikes raus. (Abgesichert durch %s)
        $query = $wpdb->prepare("SELECT brand_id FROM $tableName WHERE brand_name = %s", $brand_name);
    
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName($name): self
    {
        if(strlen($name) < 31){
            $this->name = strtoupper($name);
        }else{
            $this->name = '';
        }
        return $this;
    }
}