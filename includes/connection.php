<?php

class Connection {

    private $pdo;
 
    public function __construct() {

        $dsn = "mysql:host=localhost;dbname=petarsoc_gmap";
        $user = "petarsoc";
        $password = "4oN7aN24ni";

        try {
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo->query("SET NAMES 'utf8'");
        } catch (PDOException $exc) {
            echo $exc->getMessage();
            exit();
        }
    }

    public function getDb() {
        if ($this->pdo instanceof PDO) {
            return $this->pdo;
        }
    }

}

//a5726148_gmap	a5726148_gmap	mysql8.000webhost.com		lozinka1
//$dsn = "mysql:host=mysql8.000webhost.com;dbname=a5726148_gmap";