<?php
include '../db.php'; // Connect to database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $scheme_name = $_POST['scheme_name'];
    $description = $_POST['description'];
    $eligibility = $_POST['eligibility'];
    $benefits = $_POST['benefits'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'] ?? NULL;
    $documents = $_POST['documents'];
    $application_process = $_POST['application_process'];
    $contact = $_POST['contact'];

    $sql = "INSERT INTO schemes (scheme_name, description, eligibility, benefits, start_date, end_date, documents, application_process, contact) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $scheme_name, $description, $eligibility, $benefits, $start_date, $end_date, $documents, $application_process, $contact);

    if ($stmt->execute()) {
        echo "<script>alert('Scheme added successfully!'); window.location.href='../dashboard/gov_official_dashboard.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request!";
}
?>
