<?php

$user = json_decode(file_get_contents("php://input"), false);

function NoAmpersand($aggu) {
        return str_replace("&", "and", $aggu);
}

$token = $user->token;
$message = "Congratulations, You've registered to receive line message for \"" . NoAmpersand($user->desc) . "\" fingers scan information.";

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

echo json_encode($response);

?>