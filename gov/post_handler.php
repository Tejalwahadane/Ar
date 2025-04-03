<?php
include('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_content = mysqli_real_escape_string($conn, $_POST['post_content']);
    $image_name = "";

    // Image Upload Handling
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "../uploads/";  // Ensure this directory exists and is writable
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Allow only specific image formats
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_types)) {
            die("Error: Only JPG, JPEG, PNG, and GIF files are allowed.");
        }

        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            die("Error uploading the image.");
        }
    }

    // Insert into posts table
    $sql = "INSERT INTO gov_posts (content, image) VALUES ('$post_content', '$image_name')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: ../dashboard/gov_official_dashboard.php"); // Redirect after successful submission
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
