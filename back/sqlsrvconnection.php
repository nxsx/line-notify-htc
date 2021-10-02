<?php

define("HRPORTAL_CONNECTION", "sqlsrv:server=00000;Database=00000");
define("HRPORTAL_USERADMIN", "00000");
define("HRPORTAL_PASSWORDADMIN", "00000");

class DatabaseConnection 
{
        private $hrportal;
        function __construct() 
        {
                $connection = new PDO(
                        HRPORTAL_CONNECTION, 
                        HRPORTAL_USERADMIN, 
                        HRPORTAL_PASSWORDADMIN
                );
                $connection->setAttribute(
                        PDO::ATTR_ERRMODE, 
                        PDO::ERRMODE_EXCEPTION
                );
                $this->hrportal = $connection;
        }

        public function CallHRPortal() 
        {
                return $this->hrportal;
        }

}

?>