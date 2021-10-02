<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Origin: http://10.35.10.47");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
header("Access-Control-Allow-Methods: GET");

require_once("sqlsrvconnection.php");

class GroupDivisionData extends DatabaseConnection
{
        public function getGroupDivision()
        {
                $sql = "SELECT [GDivisionID] AS [id], [GDivisionDescEN] AS [name] FROM [HRPortal].[dbo].[tbGroupDivision] (NOLOCK) ";
                $stm = DatabaseConnection::CallHRPortal()->prepare($sql);
                $stm->execute();

                return $stm->fetchAll(PDO::FETCH_ASSOC);
        }
}

$groupdivision = new GroupDivisionData();

if ($_SERVER["REQUEST_METHOD"] === "GET")
{
        $results = $groupdivision->getGroupDivision();
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