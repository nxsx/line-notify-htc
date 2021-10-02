<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Origin: http://10.35.10.47");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
header("Access-Control-Allow-Methods: POST");

require_once("mysqlconnection.php");
$mysql = new MySqlDatabase();

function getKeyCode() {
        $alphabet = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
        return date("Ymdhis") . $alphabet[rand(0, 25)] . $alphabet[rand(0, 25)];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") 
{
        $formObject = json_decode(file_get_contents("php://input"), false);
        
                if ($formObject->messageform == '1') {

                        $sqlCheck = "SELECT * FROM tbl_linetoken_detail WHERE send_empid = :empid AND send_type = :type AND send_code = :code";
                        $paramsCheck = array(
                                ':empid' => $formObject->empid,
                                ':type' => $formObject->messagetype,
                                ':code' => $formObject->typecode
                        );

                        $stmCheck = $mysql->CallWebservices()->prepare($sqlCheck);
                        $stmCheck->execute($paramsCheck);
                        $rsCheck = $stmCheck->fetchAll(PDO::FETCH_ASSOC);
                        
                        if (count($rsCheck) === 1) {
                                $response = array(
                                        'status' => 0,
                                        'message' => "You have registered before, please check your status."
                                );
                        } else {
                                $sql = "INSERT INTO tbl_linetoken_detail(send_empid, send_empname, send_code, send_type, send_token, send_monday, send_tuesday, send_wednesday, send_thursday, send_friday, send_saturday, send_sunday, send_desc, keycode) VALUES(:empid, :empname, :code, :type, :token, :monday, :tuesday, :wednesday, :thursday, :friday, :saturday, :sunday, :desc, :keycode)";
                                $params = array(
                                        ':empid' => $formObject->empid,
                                        ':empname' => $formObject->empname,
                                        ':code' => $formObject->typecode,
                                        ':type' => $formObject->messagetype,
                                        ':token' => $formObject->emptoken,
                                        ':monday' => $formObject->monday,
                                        ':tuesday' => $formObject->tuesday,
                                        ':wednesday' => $formObject->wednesday,
                                        ':thursday' => $formObject->thursday,
                                        ':friday' => $formObject->friday,
                                        ':saturday' => $formObject->saturday,
                                        ':sunday' => $formObject->sunday,
                                        ':desc' => $formObject->typename,
                                        ':keycode' => "D" . getKeyCode()
                                );
                                
                                try {
                                        $stm = $mysql->CallWebservices()->prepare($sql);
                                        $stm->execute($params);

                                        $response = array(
                                                'status' => 1,
                                                'message' => "Register successfully."
                                        );
                                } catch (PDOException $e) {
                                        $response = array(
                                                'status' => 0,
                                                'message' => "Error: " . $e->getMessage()
                                        );
                                }
                        }
                        
                        echo json_encode($response);

                }

                if ($formObject->messageform == '2') {
                        
                        $sqlCheck = "SELECT * FROM tbl_linetoken_summary WHERE send_empid = :empid AND send_type = :type AND send_code = :code";
                        $paramsCheck = array(
                                ':empid' => $formObject->empid,
                                ':type' => $formObject->messagetype,
                                ':code' => $formObject->typecode
                        );

                        $stmCheck = $mysql->CallWebservices()->prepare($sqlCheck);
                        $stmCheck->execute($paramsCheck);
                        $rsCheck = $stmCheck->fetchAll(PDO::FETCH_ASSOC);
                        
                        if (count($rsCheck) === 1) {
                                $response = array(
                                        'status' => 0,
                                        'message' => "You have registered before, please check your status."
                                );
                        } else {
                                $sql = "INSERT INTO tbl_linetoken_summary(send_empid, send_empname, send_code, send_type, send_token, send_monday, send_tuesday, send_wednesday, send_thursday, send_friday, send_saturday, send_sunday, send_desc, keycode) VALUES(:empid, :empname, :code, :type, :token, :monday, :tuesday, :wednesday, :thursday, :friday, :saturday, :sunday, :desc, :keycode)";
                                $params = array(
                                        ':empid' => $formObject->empid,
                                        ':empname' => $formObject->empname,
                                        ':code' => $formObject->typecode,
                                        ':type' => $formObject->messagetype,
                                        ':token' => $formObject->emptoken,
                                        ':monday' => $formObject->monday,
                                        ':tuesday' => $formObject->tuesday,
                                        ':wednesday' => $formObject->wednesday,
                                        ':thursday' => $formObject->thursday,
                                        ':friday' => $formObject->friday,
                                        ':saturday' => $formObject->saturday,
                                        ':sunday' => $formObject->sunday,
                                        ':desc' => $formObject->typename,
                                        ':keycode' => "S" . getKeyCode()
                                );
                                
                                try {
                                        $stm = $mysql->CallWebservices()->prepare($sql);
                                        $stm->execute($params);

                                        $response = array(
                                                'status' => 1,
                                                'message' => "Register successfully."
                                        );
                                } catch (PDOException $e) {
                                        $response = array(
                                                'status' => 0,
                                                'message' => "Error: " . $e->getMessage()
                                        );
                                }
                        }
                        
                        echo json_encode($response);

                }
}

if ($_SERVER["REQUEST_METHOD"] !== "POST")
{
        header("HTTP/1.0 405 Method Not Allowed");
}

?>