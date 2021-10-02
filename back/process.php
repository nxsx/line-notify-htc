<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Origin: http://10.35.10.47");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
header("Access-Control-Allow-Methods: GET");

require_once("sqlsrvconnection.php");

class ProcessData extends DatabaseConnection
{
        public function getProcess()
        {
                $sql = "SELECT [ProcessID] AS [id], [ProcessName] AS [name] FROM [HRPortal].[dbo].[tbProcess] (NOLOCK) WHERE [ProcessName] NOT LIKE 'DELETED%' ";
                $stm = DatabaseConnection::CallHRPortal()->prepare($sql);
                $stm->execute();

                return $stm->fetchAll(PDO::FETCH_ASSOC);
        }
}

$process = new ProcessData();

if ($_SERVER["REQUEST_METHOD"] === "GET")
{
        $results = $process->getProcess();
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