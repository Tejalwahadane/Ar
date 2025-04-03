<?php
$apiKey = "51058dd2581fcc24cd1d3f01a66146d2"; // Replace with OpenWeatherMap API Key
$city = isset($_GET['city']) ? $_GET['city'] : "Pune"; // Default city

$apiUrl = "https://api.openweathermap.org/data/2.5/forecast?q=$city&appid=$apiKey&units=metric";
$response = file_get_contents($apiUrl);
$data = json_decode($response, true);

if ($data && isset($data['list'])) {
    $weatherData = [];

    foreach ($data['list'] as $entry) {
        $date = date("D", strtotime($entry['dt_txt'])); // Get day name
        if (!isset($weatherData[$date])) {
            $weatherData[$date] = [
                "temperature" => [],
                "humidity" => [],
                "pressure" => []
            ];
        }
        $weatherData[$date]["temperature"][] = $entry['main']['temp'];
        $weatherData[$date]["humidity"][] = $entry['main']['humidity'];
        $weatherData[$date]["pressure"][] = $entry['main']['pressure'];
    }

    $averageWeather = [];
    foreach ($weatherData as $day => $values) {
        $averageWeather[] = [
            "day" => $day,
            "temperature" => round(array_sum($values["temperature"]) / count($values["temperature"]), 2),
            "humidity" => round(array_sum($values["humidity"]) / count($values["humidity"]), 2),
            "pressure" => round(array_sum($values["pressure"]) / count($values["pressure"]), 2)
        ];
    }

    echo json_encode($averageWeather);
} else {
    echo json_encode(["error" => "Invalid city name or API issue"]);
}
?>
