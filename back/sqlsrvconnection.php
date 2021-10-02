<?php

define("HRPORTAL_CONNECTION", "sqlsrv:server=190.7.10.22;Database=HRPortal");
define("HRPORTAL_USERADMIN", "hruser");
define("HRPORTAL_PASSWORDADMIN", "");

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