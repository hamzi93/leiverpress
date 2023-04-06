<?php

class BikeDetail{

    private $bd_id;
    private $bd_modelname;
    private $bd_modelyear;
    private $bd_image;
    private $bd_dayprice;
    private $bd_discount;
    private $bd_disountdays;
    private $bd_performancePs;
    private $bd_engine;
    private $bd_torque; //Drehmoment
    private $bd_capacity; //Leistung
    private $bd_weight;
    private $br_id; //brand ID
    private $bl_id; //bike license ID

    function __construct($id, $modelname, $modelyear, $image, $dayprice, $discount, $discountdays, $performancePs, $engine, $torque, $capacity,
    $weight, $brandId, $bikeLicenseId){
        $this->setId($id);
        $this->setModelname($modelname);
        $this->setModelyear($modelyear);
        $this->setImage($image);
        $this->setDayprice($dayprice);
        $this->setDiscount($discount);
        $this->setDisountdays($discountdays);
        $this->setPerformancePs($performancePs);
        $this->setEngine($engine);
        $this->setTorque($torque);
        $this->setCapacity($capacity);
        $this->setWeight($weight);
        $this->setBrId($brandId);
        $this->setBlId($bikeLicenseId);
    }

    static function getAllBikeDetailsFromJson(){
        require_once(MY_PLUGIN_PATH . 'lp-functions/model-functions.php');
        
        $bikeDetailObjects = getFromJson(MY_PLUGIN_PATH . 'lp-data/bikedetail_data.json');
        $bikeDetailCollection = array();
        foreach ($bikeDetailObjects as $bikeDetail) {

            $bikeDetailCollection[] = new BikeDetail($bikeDetail->bikedetail_id, $bikeDetail->bikedetail_modelname, $bikeDetail->bikedetail_modelyear, $bikeDetail->bikedetail_image,
             $bikeDetail->bikedetail_dayprice, $bikeDetail->bikedetail_discount, $bikeDetail->bikedetail_discountdays, $bikeDetail->bikedetail_performanceps, $bikeDetail->bikedetail_engine,
             $bikeDetail->bikedetail_torque, $bikeDetail->bikedetail_capacity, $bikeDetail->bikedetail_weight, $bikeDetail->brand_id, $bikeDetail->bikelicense_id);
        }
        return $bikeDetailCollection;
    }

    /**
     * Get the value of bd_id
     */
    function getId()
    {
        return $this->bd_id;
    }

    /**
     * Set the value of bd_id
     */
    function setId($bd_id): self
    {
        $this->bd_id = $bd_id;

        return $this;
    }

    /**
     * Get the value of bd_modelname
     */
    function getModelname()
    {
        return $this->bd_modelname;
    }

    /**
     * Set the value of bd_modelname
     */
    function setModelname($bd_modelname): self
    {
        $this->bd_modelname = $bd_modelname;

        return $this;
    }

    /**
     * Get the value of bd_modelyear
     */
    function getModelyear()
    {
        return $this->bd_modelyear;
    }

    /**
     * Set the value of bd_modelyear
     */
    function setModelyear($bd_modelyear): self
    {
        $this->bd_modelyear = $bd_modelyear;

        return $this;
    }

    /**
     * Get the value of bd_dayprice
     */
    function getDayprice()
    {
        return $this->bd_dayprice;
    }

    /**
     * Set the value of bd_dayprice
     */
    function setDayprice($bd_dayprice): self
    {
        $this->bd_dayprice = $bd_dayprice;

        return $this;
    }

    /**
     * Get the value of bd_discount
     */
    function getDiscount()
    {
        return $this->bd_discount;
    }

    /**
     * Set the value of bd_discount
     */
    function setDiscount($bd_discount): self
    {
        $this->bd_discount = $bd_discount;

        return $this;
    }

    /**
     * Get the value of bd_disountdays
     */
    function getDisountdays()
    {
        return $this->bd_disountdays;
    }

    /**
     * Set the value of bd_disountdays
     */
    function setDisountdays($bd_disountdays): self
    {
        $this->bd_disountdays = $bd_disountdays;

        return $this;
    }

    /**
     * Get the value of bd_performancePs
     */
    function getPerformancePs()
    {
        return $this->bd_performancePs;
    }

    /**
     * Set the value of bd_performancePs
     */
    function setPerformancePs($bd_performancePs): self
    {
        $this->bd_performancePs = $bd_performancePs;

        return $this;
    }

    /**
     * Get the value of bd_engine
     */
    function getEngine()
    {
        return $this->bd_engine;
    }

    /**
     * Set the value of bd_engine
     */
    function setEngine($bd_engine): self
    {
        $this->bd_engine = $bd_engine;

        return $this;
    }

    /**
     * Get the value of bd_torque
     */
    function getTorque()
    {
        return $this->bd_torque;
    }

    /**
     * Set the value of bd_torque
     */
    function setTorque($bd_torque): self
    {
        $this->bd_torque = $bd_torque;

        return $this;
    }

    /**
     * Get the value of bd_capacity
     */
    function getCapacity()
    {
        return $this->bd_capacity;
    }

    /**
     * Set the value of bd_capacity
     */
    function setCapacity($bd_capacity): self
    {
        $this->bd_capacity = $bd_capacity;

        return $this;
    }

    /**
     * Get the value of bd_weight
     */
    function getWeight()
    {
        return $this->bd_weight;
    }

    /**
     * Set the value of bd_weight
     */
    function setWeight($bd_weight): self
    {
        $this->bd_weight = $bd_weight;

        return $this;
    }

    /**
     * Get the value of br_id
     */
    function getBrId()
    {
        return $this->br_id;
    }

    /**
     * Set the value of br_id
     */
    function setBrId($br_id): self
    {
        $this->br_id = $br_id;

        return $this;
    }

    /**
     * Get the value of bl_id
     */
    function getBlId()
    {
        return $this->bl_id;
    }

    /**
     * Set the value of bl_id
     */
    function setBlId($bl_id): self
    {
        $this->bl_id = $bl_id;

        return $this;
    }

    /**
     * Get the value of bd_image
     */
    function getImage()
    {
        return $this->bd_image;
    }

    /**
     * Set the value of bd_image
     */
    function setImage($bd_image): self
    {
        $this->bd_image = $bd_image;

        return $this;
    }
}