<?php
session_start();

// Redirect logged-in users to their dashboard
if (isset($_SESSION["user_id"])) {
    switch ($_SESSION["role"]) {
        case "farmer":
            header("Location: dashboard/farmer_dashboard.php");
            exit();
        case "gov_official":
            header("Location: dashboard/gov_official_dashboard.php");
            exit();
        case "expert":
            header("Location: dashboard/expert_dashboard.php");
            exit();
        case "worker":
            header("Location: dashboard/worker_dashboard.php");
            exit();
    }
}
?>
<?php include "assets/header.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KisanSetu - Connecting Farmers</title>
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>

    <div class="container">
        <header>
            <h1>Welcome to KisanSetu</h1>
            <p>Empowering farmers with technology and support</p>
        </header>

        <div class="buttons">
            <a href="registration/login.php" class="btn">Login</a>
            <a href="registration/registration.php" class="btn">Register</a>
        </div>
    </div>

</body>
</html>

<a href="../registration/logout.php">
    <button type="button">Logout</button>
</a>
