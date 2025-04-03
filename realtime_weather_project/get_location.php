<?php
$ip = $_SERVER['REMOTE_ADDR'];
$locationApiUrl = "http://ip-api.com/json/$ip";

$response = file_get_contents($locationApiUrl);
$locationData = json_decode($response, true);

if ($locationData && $locationData['status'] == 'success') {
    echo json_encode(["city" => $locationData['city']]);
} else {
    echo json_encode(["error" => "Unable to detect location"]);
}
?>
