<?php
header('Content-Type: application/json');

// Function to predict crop using Python script
function predictCrop($N, $P, $K, $temperature, $humidity, $ph, $rainfall) {
    $command = sprintf(
        'python predict.py %s %s %s %s %s %s %s 2>&1',
        escapeshellarg($N),
        escapeshellarg($P),
        escapeshellarg($K),
        escapeshellarg($temperature),
        escapeshellarg($humidity),
        escapeshellarg($ph),
        escapeshellarg($rainfall)
    );

    $output = shell_exec($command);
    return trim($output);
}

// Handle form submission via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputs = [
        'N' => $_POST['N'],
        'P' => $_POST['P'],
        'K' => $_POST['K'],
        'temperature' => $_POST['temperature'],
        'humidity' => $_POST['humidity'],
        'ph' => $_POST['ph'],
        'rainfall' => $_POST['rainfall']
    ];

    $recommendedCrop = predictCrop(
        $inputs['N'], $inputs['P'], $inputs['K'],
        $inputs['temperature'], $inputs['humidity'],
        $inputs['ph'], $inputs['rainfall']
    );

    if (!empty($recommendedCrop)) {
        echo json_encode([
            'success' => true,
            'crop' => $recommendedCrop,
            'inputs' => $inputs
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Failed to predict crop. Check your inputs or Python script.'
        ]);
    }
}
?>
