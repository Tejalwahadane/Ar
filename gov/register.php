<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $aadhaar = $_POST['aadhaar'];
    $income = $_POST['income'];
    $land_size = $_POST['land_size'];
    $previous_enrollments = $_POST['previous_enrollments'];
    $crop_losses = $_POST['crop_losses'];
    $debt_status = $_POST['debt_status'] === "yes" ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO farmers (name, aadhaar, income, land_size, previous_enrollments, crop_losses, debt_status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssddidd", $name, $aadhaar, $income, $land_size, $previous_enrollments, $crop_losses, $debt_status);
    $stmt->execute();
    $stmt->close();

    $output = shell_exec("python ../scripts/rank_farmers.py 2>&1");
    

    echo "Farmer Registered Successfully!";
}
?>