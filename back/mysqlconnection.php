<?php

define("MYSQL_CONNECTION", "mysql:host=00000;dbname=00000");
define("MYSQL_USERNAME", "00000");
define("MYSQL_PASSWORD", "00000");
define("MYSQL_CHARSET", "set names utf8");

class MySqlDatabase 
{
        private $webservices;
        public function __construct() 
        {
                try {
                        $this->webservices = new PDO (
                                MYSQL_CONNECTION,
                                MYSQL_USERNAME,
                                MYSQL_PASSWORD
                        );
                        $this->webservices->setAttribute (
                                PDO::ATTR_ERRMODE,
                                PDO::ERRMODE_EXCEPTION
                        );
                        $this->webservices->exec (
                                MYSQL_CHARSET
                        );
                } catch (PDOException $e) {
                        throw new Exception($e->getMessage());
                }
        }

        public function CallWebservices() 
        {
                return $this->webservices;
        }
        
}

?>