<?php

class BookingDetail{

    private $bkd_id;
    private $bkd_beginDate;
    private $bkd_endDate;
    private $bkd_price;
    private $b_id; //bike_id
    private $cu_id; //customer_id
    private $bk_id; //booking_id
    //private $c_id; //clothing_id
    private $errors;

    function __construct($beginDate, $endDate, $bikeId, $bookingId){
        $this->setBeginDate($beginDate);
        $this->setEndDate($endDate);
        $this->setBId($bikeId);
        $this->setBkId($bookingId);
        $this->errors = [];
    }

    static function getAllBookingDetailsFromJson(){
        require_once(MY_PLUGIN_PATH . 'lp-functions/model-functions.php');

        $bookingDetailObjects = getFromJson(MY_PLUGIN_PATH . 'lp-data/bookingdetail_data.json');
        $bookingDetailCollection = array();
        foreach ($bookingDetailObjects as $bookingDetail) {
            $tempBookingDetail = new BookingDetail($bookingDetail->bookingdetail_begindate, $bookingDetail->bookingdetail_enddate, $bookingDetail->bike_id, $bookingDetail->booking_id);
            $tempBookingDetail->setId($bookingDetail->bookingdetail_id);
            $tempBookingDetail->setPrice($bookingDetail->bookingdetail_price);
            $tempBookingDetail->setCuId($bookingDetail->customer_id);
            $bookingDetailCollection[] = $tempBookingDetail; 
        }
        return $bookingDetailCollection;
    }

    
    /**
     * Get the value of bkd_id
     */
    function getId()
    {
        return $this->bkd_id;
    }

    /**
     * Set the value of bkd_id
     */
    function setId($bkd_id): self
    {
        $this->bkd_id = $bkd_id;

        return $this;
    }

    /**
     * Get the value of bkd_begindDate
     */
    function getBeginDate()
    {
        return $this->bkd_beginDate;
    }

    /**
     * Set the value of bkd_begindDate
     */
    function setBeginDate($bkd_beginDate): self
    {
        $this->bkd_beginDate = $bkd_beginDate;

        return $this;
    }

    /**
     * Get the value of bkd_endDate
     */
    function getEndDate()
    {
        return $this->bkd_endDate;
    }

    /**
     * Set the value of bkd_endDate
     */
    function setEndDate($bkd_endDate): self
    {
        $this->bkd_endDate = $bkd_endDate;

        return $this;
    }

    /**
     * Get the value of bkd_price
     */
    function getPrice()
    {
        return $this->bkd_price;
    }

    /**
     * Set the value of bkd_price
     */
    function setPrice($bkd_price): self
    {
        $this->bkd_price = $bkd_price;

        return $this;
    }

    /**
     * Get the value of b_id
     */
    function getBId()
    {
        return $this->b_id;
    }

    /**
     * Set the value of b_id
     */
    function setBId($b_id): self
    {
        $this->b_id = $b_id;

        return $this;
    }

    /**
     * Get the value of cu_id
     */
    function getCuId()
    {
        return $this->cu_id;
    }

    /**
     * Set the value of cu_id
     */
    function setCuId($cu_id): self
    {
        $this->cu_id = $cu_id;

        return $this;
    }

    /**
     * Get the value of bk_id
     */
    function getBkId()
    {
        return $this->bk_id;
    }

    /**
     * Set the value of bk_id
     */
    function setBkId($bk_id): self
    {
        $this->bk_id = $bk_id;

        return $this;
    }

    /**
     * Get the value of errors
     */
    function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set the value of errors
     */
    function setErrors($errors): self
    {
        $this->errors = $errors;

        return $this;
    }
}