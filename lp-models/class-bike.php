<?php


class Bike
{
    private $id;
    private $name;
    private $preis;
    private $rabatt;
    private $bild;
    private $brandId;
    private $errors;

    function __construct($id, string $name, int $preis, bool $rabatt, $bild, $brandId)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setPreis($preis);
        $this->setRabatt($rabatt);
        $this->setBild($bild);
        $this->setBrandId($brandId);
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

    public static function getAllBikesFromJson()
    {
        $bikeString = file_get_contents(MY_PLUGIN_PATH . 'lp-data/bike_data.json');
        if ($bikeString === false) {
            return null;
        }
        $bikeObjects = json_decode($bikeString);
        $bikeCollection = array();
        foreach ($bikeObjects as $bike) {

            $bikeCollection[] = new Bike($bike->bike_id, $bike->bike_name, $bike->bike_preis, $bike->bike_rabatt, $bike->bike_bild, $bike->brand_id);
        }
        return $bikeCollection;
    }

    public static function getAllBikes()
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

    public static function getBikesByBrand($brand_name)
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

    public static function getBikePriceById($bike_id)
    {
        global $wpdb;

        $tableName = $wpdb->prefix . 'bike';
        $bikePreis = $wpdb->get_var("SELECT bike_preis FROM $tableName WHERE bike_id = $bike_id");

        return $bikePreis;
    }

    public static function getAllAccessibleBikes($abholdatum, $rueckgabedatum)
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

    public static function getAllAccessibleBikesByBrand($abholdatum, $rueckgabedatum, $brandId)
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
        $this->name = $name;

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
     * Get the value of rabatt
     */
    public function getRabatt()
    {
        return $this->rabatt;
    }

    /**
     * Set the value of rabatt
     */
    public function setRabatt($rabatt): self
    {
        $this->rabatt = $rabatt;

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

    /**
     * Get the value of bild
     */
    public function getBild()
    {
        return $this->bild;
    }

    /**
     * Set the value of bild
     */
    public function setBild($bild): self
    {
        $this->bild = $bild;

        return $this;
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
     * Get the value of brandId
     */
    public function getBrandId()
    {
        return $this->brandId;
    }

    /**
     * Set the value of brandId
     */
    public function setBrandId($brandId): self
    {
        $this->brandId = $brandId;

        return $this;
    }
}
