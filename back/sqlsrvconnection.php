<?php

define("HRPORTAL_CONNECTION", "sqlsrv:server=111111;Database=111111");
define("HRPORTAL_USERADMIN", "111111");
define("HRPORTAL_PASSWORDADMIN", "111111");

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