<?php

//braucht unbedingt einen boolean mit bestätigt(confirmed)
class Booking
{
    private $bk_id;
    private $bk_date;
    private $bk_confirmed;
    private $bk_totalPrice;
    private $errors;

    function __construct()
    {
        $this->errors = [];
    }

    /*function calculateBookingPrice($tagesPreis)
    {
        $this->preis = ($tagesPreis) * ((strtotime($this->rueckgabedatum) - strtotime($this->abholdatum)) / (60 * 60 * 24));
        return $this->preis;
    }*/

    static function getAllBookingsFromJson(){
        require_once(MY_PLUGIN_PATH . 'lp-functions/model-functions.php');

        $bookingObjects = getFromJson(MY_PLUGIN_PATH . 'lp-data/booking_data.json');
        $bookingCollection = array();
        foreach ($bookingObjects as $booking) {
            $tempBooking = new Booking();
            $tempBooking->setId($booking->booking_id);
            $tempBooking->setDate($booking->booking_date);
            $tempBooking->setConfirmed($booking->booking_confirmed);
            $tempBooking->setTotalPrice($booking->booking_totalprice);
            $bookingCollection[] = $tempBooking; 
        }
        return $bookingCollection;
    }

    /**
     * Get the value of bk_id
     */
    function getId()
    {
        return $this->bk_id;
    }

    /**
     * Set the value of bk_id
     */
    function setId($bk_id): self
    {
        $this->bk_id = $bk_id;

        return $this;
    }

    /**
     * Get the value of bk_date
     */
    function getDate()
    {
        return $this->bk_date;
    }

    /**
     * Set the value of bk_date
     */
    function setDate($bk_date): self
    {
        $this->bk_date = $bk_date;

        return $this;
    }

    /**
     * Get the value of bk_confirmed
     */
    function getConfirmed()
    {
        return $this->bk_confirmed;
    }

    /**
     * Set the value of bk_confirmed
     */
    function setConfirmed($bk_confirmed): self
    {
        $this->bk_confirmed = $bk_confirmed;

        return $this;
    }

    /**
     * Get the value of bk_totalPrice
     */
    function getTotalPrice()
    {
        return $this->bk_totalPrice;
    }

    /**
     * Set the value of bk_totalPrice
     */
    function setTotalPrice($bk_totalPrice): self
    {
        $this->bk_totalPrice = $bk_totalPrice;

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
