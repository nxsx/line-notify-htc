<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Origin: http://10.35.10.47");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
header("Access-Control-Allow-Methods: GET");

require_once("mysqlconnection.php");
$mysql = new MySqlDatabase();

if ($_SERVER["REQUEST_METHOD"] === "GET") 
{
        $sql = "SELECT * FROM tbl_linetoken_detail WHERE send_empid = :id UNION SELECT * FROM tbl_linetoken_summary WHERE send_empid = :id";
        $stm = $mysql->CallWebservices()->prepare($sql);
        $stm->bindParam(':id', $_GET["id"], PDO::PARAM_STR);

        try {
                $stm->execute();
        } catch (PDOException $e) {
                $reponse = array(
                        'status' => 0,
                        'message' => "Error: " . $e->getMessage()
                );

                echo json_encode($reponse);
                exit();
        }

        echo json_encode($stm->fetchAll(PDO::FETCH_ASSOC));
}

if ($_SERVER["REQUEST_METHOD"] !== "GET")
{
        header("HTTP/1.0 405 Method Not Allowed");
}

?>