<?php

$user = json_decode(file_get_contents("php://input"), false);

function getRandomOtp() {
        return rand(100000, 999999);
}

function getRandomRef() {
        $alphabet = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
        return $alphabet[rand(0, 25)] . $alphabet[rand(0, 25)] . $alphabet[rand(0, 25)] . $alphabet[rand(0, 25)];
}

$token = $user->token;
$key = $user->keycode;

$otp = getRandomOtp();
$ref = getRandomRef();

$message = "Your OTP is " . $otp . " (Ref. " . $ref . ") to proceed your transaction with system. OTP will be expired within 3 min.";

$url = "https://notify-api.line.me/api/notify";
$fields = "message=" . $message;
$type = "Content-Type: application/x-www-form-urlencoded";
$auth = "Authorization: Bearer " . $token;
$headers = [
        $type,
        $auth
];

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($curl);
curl_close($curl);

$response = json_decode($result, false);
$response->otp = $otp;
$response->ref = $ref;
$response->key = $key;

echo json_encode($response);

?>