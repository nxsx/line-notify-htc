<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Origin: http://10.35.10.47");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
header("Access-Control-Allow-Methods: GET");

require_once("sqlsrvconnection.php");

class DivisionData extends DatabaseConnection
{
        public function getDivision()
        {
                $sql = "SELECT [DivisionID] AS [id], CASE SUBSTRING([DivisionName], 1, 1) WHEN ' ' THEN SUBSTRING([DivisionName], 2, LEN([DivisionName])) ELSE [DivisionName] END AS [name] FROM [HRPortal].[dbo].[tbDivision] (NOLOCK) WHERE [GDivisionID] != '00' ";
                $stm = DatabaseConnection::CallHRPortal()->prepare($sql);
                $stm->execute();

                return $stm->fetchAll(PDO::FETCH_ASSOC);
        }
}

$division = new DivisionData();

if ($_SERVER["REQUEST_METHOD"] === "GET")
{
        $results = $division->getDivision();
        if (count($results) === 0)
        {
                header("HTTP/1.0 204 No Content");
        }
        else
        {
                echo json_encode($results);
        }
}

if ($_SERVER["REQUEST_METHOD"] !== "GET")
{
        header("HTTP/1.0 405 Method Not Allowed");
}

?>