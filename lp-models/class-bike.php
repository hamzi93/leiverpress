<?php


class Bike
{
    private $b_id;
    private $b_licenseplate;
    private $bd_id;
    private $errors;

    function __construct($id, $licenseplate, $bikeDetailId)
    {
        $this->setId($id);
        $this->setLicensePlate($licenseplate);
        $this->setBdId($bikeDetailId);
        $this->errors = [];
    }

    /*function validate()
    {
        return $this->validateHelperStr('Name', 'bike_name', $this->name, 255) &
            $this->validateHelperInt('Preis', 'bike_preis', $this->preis, 11);
    }

    private function validateHelperStr($label, $key, $value, $maxLength)
    {
        global $wpdb;
        if (strlen($value) == 0) {
            $this->errors[$key] = "$label darf nicht leer sein!";
            return false;
        } else if (strlen($value) > $maxLength) {
            $this->errors[$key] = "$label zu lang (max. $maxLength Zeichen)!";
            return false;
        } else {
            return true;
        }
    }

    private function validateHelperInt($label, $key, $value, $digit)
    {
        if ($value < 0) {
            $this->errors[$key] = "$label darf nicht negativ sein!";
            return false;
        } else {
            return true;
        }
    } */

    static function getAllBikesFromJson()
    {
        require_once(MY_PLUGIN_PATH . 'lp-functions/model-functions.php');
        
        $bikeObjects = getFromJson(MY_PLUGIN_PATH . 'lp-data/bike_data.json');
        $bikeCollection = array();
        foreach ($bikeObjects as $bike) {

            $bikeCollection[] = new Bike($bike->bike_id, $bike->bike_licenseplate, $bike->bikedetail_id);
        }
        return $bikeCollection;
    }

    static function getAllBikes()
    {
        global $wpdb;
        //tablename so angegeben, weil wpdb->bike nicht funktioniert
        $tableName = $wpdb->prefix . 'bike';

        $sql = $wpdb->get_results("SELECT * FROM $tableName ORDER BY bike_id ASC LIMIT 0,4");
        $bikesCollection = array();
        foreach ($sql as $bike) {
            $bikesCollection[] = new Bike($bike->bike_id, $bike->bike_name, $bike->bike_preis, $bike->bike_rabatt, $bike->bike_bild, $bike->brand_id);
        }
        return $bikesCollection;
    }

    static function getBikesByBrand($brand_name)
    {
        global $wpdb;

        //tablename so angegeben, weil wpdb->bike nicht funktioniert
        $tableName = $wpdb->prefix . 'bike';
        $refTableName = $wpdb->prefix . 'brand';

        $sql = $wpdb->get_results("SELECT * FROM $tableName as bikes JOIN $refTableName as brands ON bikes.brand_id = brands.brand_id WHERE brands.brand_name = '$brand_name'");
        $bikesCollection = array();
        foreach ($sql as $bike) {
            $bikesCollection[] = new Bike($bike->bike_id, $bike->bike_name, $bike->bike_preis, $bike->bike_rabatt, $bike->bike_bild, $bike->brand_id);
        }
        return $bikesCollection;
    }

    static function getBikePriceById($bike_id)
    {
        global $wpdb;

        $tableName = $wpdb->prefix . 'bike';
        $bikePreis = $wpdb->get_var("SELECT bike_preis FROM $tableName WHERE bike_id = $bike_id");

        return $bikePreis;
    }

    static function getAllAccessibleBikes($abholdatum, $rueckgabedatum)
    {
        global $wpdb;

        $tableName = $wpdb->prefix . 'bike';
        $forgeinTableName = $wpdb->prefix . 'booking';

        $sql = $wpdb->get_results
        ("SELECT *
            FROM $tableName as bikes
            WHERE bikes.bike_id NOT IN (
            SELECT bike_id
            FROM $forgeinTableName as bookings
            WHERE ((booking_abholdatum BETWEEN '$abholdatum' AND '$rueckgabedatum')
                OR (booking_rueckgabedatum BETWEEN '$abholdatum' AND '$rueckgabedatum')
                OR ('$abholdatum' BETWEEN booking_abholdatum AND booking_rueckgabedatum)
                OR ('$rueckgabedatum' BETWEEN booking_abholdatum AND booking_rueckgabedatum)))"
        );
        $bikesCollection = array();
        foreach ($sql as $bike) {
            $bikesCollection[] = new Bike($bike->bike_id, $bike->bike_name, $bike->bike_preis, $bike->bike_rabatt, $bike->bike_bild, $bike->brand_id);
        }
        return $bikesCollection;
    }

    static function getAllAccessibleBikesByBrand($abholdatum, $rueckgabedatum, $brandId)
    {
        global $wpdb;

        $tableName = $wpdb->prefix . 'bike';
        $forgeinTableName = $wpdb->prefix . 'booking';

        $sql = $wpdb->get_results
        ("SELECT *
            FROM $tableName as bikes
            WHERE bikes.bike_id NOT IN (
            SELECT bike_id
            FROM $forgeinTableName as bookings
            WHERE ((booking_abholdatum BETWEEN '$abholdatum' AND '$rueckgabedatum')
                OR (booking_rueckgabedatum BETWEEN '$abholdatum' AND '$rueckgabedatum')
                OR ('$abholdatum' BETWEEN booking_abholdatum AND booking_rueckgabedatum)
                OR ('$rueckgabedatum' BETWEEN booking_abholdatum AND booking_rueckgabedatum))) AND bikes.brand_id = '$brandId'"
        );
        $bikesCollection = array();
        foreach ($sql as $bike) {
            $bikesCollection[] = new Bike($bike->bike_id, $bike->bike_name, $bike->bike_preis, $bike->bike_rabatt, $bike->bike_bild, $bike->brand_id);
        }
        return $bikesCollection;
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


    /**
     * Get the value of id
     */
    function getId()
    {
        return $this->b_id;
    }

    /**
     * Set the value of id
     */
    function setId($id): self
    {
        $this->b_id = $id;

        return $this;
    }

    /**
     * Get the value of licenseplate
     */
    function getLicensePlate(){
        return $this->b_licenseplate;
    }

    /**
     * Set the value of licenseplate
     */
    function setLicensePlate($licenseplate): self
    {
        $this->b_licenseplate = $licenseplate;

        return $this;
    }

    /**
     * Get the value of bikedetails
     */
    function getBdId(){
        return $this->bd_id;
    }


     /**
     * Set the value of bikedetails
     */
    function setBdId($bikeDetailId): self
    {
        $this->bd_id = $bikeDetailId;

        return $this;
    }
}
