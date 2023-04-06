<?php

class Customer{

    private $cu_id;
    private $cu_firstName;
    private $cu_lastName;
    private $cu_email;
    private $cu_phoneNumber;
    //addresse, land, plz usw nötig?

    function __construct($id, $firstName, $lastName, $email, $phoneNumber){
        $this->setId($id);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setEmail($email);
        $this->setPhoneNumber($phoneNumber);
    }

    static function getAllCustomerFromJson(){
        require_once(MY_PLUGIN_PATH . 'lp-functions/model-functions.php');
        
        $customerObjects = getFromJson(MY_PLUGIN_PATH . 'lp-data/customer_data.json');
        $customerCollection = array();
        foreach ($customerObjects as $customer) {

            $customerCollection[] = new Customer($customer->customer_id, $customer->customer_firstname, $customer->customer_lastname, $customer->customer_email, $customer->customer_phonenumber);
        }
        return $customerCollection;
    }
    
    /**
     * Get the value of cu_id
     */
    function getId()
    {
        return $this->cu_id;
    }

    /**
     * Set the value of cu_id
     */
    function setId($cu_id): self
    {
        $this->cu_id = $cu_id;

        return $this;
    }

    /**
     * Get the value of cu_firstName
     */
    function getFirstName()
    {
        return $this->cu_firstName;
    }

    /**
     * Set the value of cu_firstName
     */
    function setFirstName($cu_firstName): self
    {
        $this->cu_firstName = $cu_firstName;

        return $this;
    }

    /**
     * Get the value of cu_lastName
     */
    function getLastName()
    {
        return $this->cu_lastName;
    }

    /**
     * Set the value of cu_lastName
     */
    function setLastName($cu_lastName): self
    {
        $this->cu_lastName = $cu_lastName;

        return $this;
    }

    /**
     * Get the value of cu_email
     */
    function getEmail()
    {
        return $this->cu_email;
    }

    /**
     * Set the value of cu_email
     */
    function setEmail($cu_email): self
    {
        $this->cu_email = $cu_email;

        return $this;
    }

    /**
     * Get the value of cu_phoneNumber
     */
    function getPhoneNumber()
    {
        return $this->cu_phoneNumber;
    }

    /**
     * Set the value of cu_phoneNumber
     */
    function setPhoneNumber($cu_phoneNumber): self
    {
        $this->cu_phoneNumber = $cu_phoneNumber;

        return $this;
    }
}