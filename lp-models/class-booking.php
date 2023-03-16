<?php


class Booking
{
    private $id;
    private $abholdatum;
    private $rueckgabedatum;
    private $preis;
    private $bikeId;
    private $errors;

    function __construct($id, $abholdatum, $rueckgabedatum, $preis, $bikeId)
    {
        $this->setId($id);
        $this->setAbholdatum($abholdatum);
        $this->setRueckgabedatum($rueckgabedatum);
        $this->setPreis($preis);
        $this->setBikeId($bikeId);
        $this->errors = [];
    }

    function calculateBookingPrice($tagesPreis)
    {
        $this->preis = ($tagesPreis) * ((strtotime($this->rueckgabedatum) - strtotime($this->abholdatum)) / (60 * 60 * 24));
        return $this->preis;
    }

    public static function getAllBookingsFromJson(){
        $bookingString = file_get_contents(MY_PLUGIN_PATH . 'lp-data/booking_data.json');
        if($bookingString === false){
            return null;
        }
        $bookingObjects = json_decode($bookingString);
        $bookingCollection = array();
        foreach ($bookingObjects as $booking) {
            $bookingCollection[] = new Booking($booking->booking_id, $booking->booking_abholdatum, $booking->booking_rueckgabedatum, $booking->booking_preis, $booking->bike_id); 
        }
        return $bookingCollection;
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
     * Get the value of abholdatum
     */
    public function getAbholdatum()
    {
        return $this->abholdatum;
    }

    /**
     * Set the value of abholdatum
     */
    public function setAbholdatum($abholdatum): self
    {
        $this->abholdatum = $abholdatum;

        return $this;
    }

    /**
     * Get the value of rueckgabedatum
     */
    public function getRueckgabedatum()
    {
        return $this->rueckgabedatum;
    }

    /**
     * Set the value of rueckgabedatum
     */
    public function setRueckgabedatum($rueckgabedatum): self
    {
        $this->rueckgabedatum = $rueckgabedatum;

        return $this;
    }

    /**
     * Get the value of preis
     */
    public function getPreis()
    {
        return $this->preis;
    }

    /**
     * Set the value of preis
     */
    public function setPreis($preis): self
    {
        $this->preis = $preis;

        return $this;
    }

    /**
     * Get the value of bikeId
     */
    public function getBikeId()
    {
        return $this->bikeId;
    }

    /**
     * Set the value of bikeId
     */
    public function setBikeId($bikeId): self
    {
        $this->bikeId = $bikeId;

        return $this;
    }

    /**
     * Get the value of errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set the value of errors
     */
    public function setErrors($errors): self
    {
        $this->errors = $errors;

        return $this;
    }
}
