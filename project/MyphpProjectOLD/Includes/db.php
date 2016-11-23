<?php

class CamperDB extends mysqli {

    // single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
    private $user = "phpuser";
    private $pass = "phpuserpw";
    private $dbName = "wishlist";
    private $dbHost = "localhost";

    //This method must be static, and must return an instance of the object if the object
    //does not already exist.
    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // The clone and wakeup methods prevents external instantiation of copies of the Singleton class,
    // thus eliminating the possibility of duplicate objects.
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }

    // private constructor
    private function __construct() {
        parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
        if (mysqli_connect_error()) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
        parent::set_charset('utf-8');
    }

    public function get_camper_id_by_name($name) {

        $name = $this->real_escape_string($name);

        $camper = $this->query("SELECT id FROM campers WHERE name = '" . $name . "'");
        if ($camper->num_rows > 0) {
            $row = $camper->fetch_row();
            return $row[0];
        } else
            return null;
    }

    public function get_info_by_camper_id($camperID) {
        return $this->query("SELECT firstName, lastName, cabin, storeDeposit FROM campers WHERE id=" . $camperID);
    }

    public function create_camper($firstName, $lastName, $cabin, $storeDeposit) {
        $firstName = $this->real_escape_string($firstName);
        $lastName = $this->real_escape_string($lastName);
        $cabin = $this->real_escape_string($cabin);
        $storeDeposit = $this->real_escape_string($storeDeposit);
        $this->query("INSERT INTO campers (firstName, lastName, cabin, storeDeposit) VALUES ('" . $firstName . "', '" . $lastName . "', '" . $cabin . "', '" . $storeDeposit . "' )");
    }

}
?>

