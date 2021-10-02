<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Origin: http://10.35.10.47");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
header("Access-Control-Allow-Methods: POST");

require_once("mysqlconnection.php");
$mysql = new MySqlDatabase();

if ($_SERVER["REQUEST_METHOD"] === "POST") 
{
        $formObject = json_decode(file_get_contents("php://input"), false);
                $type = substr($formObject->key, 0, 1);

                if ($type == "D") {
                        $sql = "UPDATE tbl_linetoken_detail SET send_active = '1' WHERE keycode = :keycode";
                }

                if ($type == "S") {
                        $sql = "UPDATE tbl_linetoken_summary SET send_active = '1' WHERE keycode = :keycode";
                }

                $stm = $mysql->CallWebservices()->prepare($sql);
                $stm->bindParam(':keycode', $formObject->key, PDO::PARAM_STR);

                try {
                        $stm->execute();
                        $response = array(
                                'status' => 1,
                                'text' => "The key has been activated, successfully."
                        );
                } catch (PDOException $e) {
                        $response = array(
                                'status' => 0,
                                'text' => "Error: " . $e->getMessage()
                        );
                }

                echo json_encode($response);
}

if ($_SERVER["REQUEST_METHOD"] !== "POST")
{
        header("HTTP/1.0 405 Method Not Allowed");
}

?>