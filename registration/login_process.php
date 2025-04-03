<?php
include "../db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["username"]) || !isset($_POST["password"])) {
        die("Error: Missing username or password!");
    }

    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, role, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $role, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["role"] = $role;
            header("Location: ../dashboard/{$role}_dashboard.php");
            exit(); // ✅ Prevent further execution
        } else {
            echo "Valid credentials!";
        }
    } else {
        echo "Invalid credentials!";
    }

    $stmt->close();
    $conn->close();
}
?>
