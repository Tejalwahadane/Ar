<?php
include('../db.php'); // Include your database connection file

$sql = "SELECT * FROM schemes"; // Query to fetch all schemes
$result = mysqli_query($conn, $sql); // Execute query

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Government Schemes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel='stylesheet' href="../assets/css/schemes.css">
</head>

<body>
<header class="header">
    <h2>KishanSetu</h2>
    <input type="text" placeholder="Search..." class="search-bar">
    <nav>
        <a href="../dashboard/farmer_dashboard.php">Home</a>
        <a href="../farmer/schemes.php">Scheme</a>
        <a href="../dashboard/experts_community.php">Community</a>
        <a href="../farmer/index3.html">Workers</a>
        <a href="index.html">Products</a>

        <!-- Features Dropdown -->
        <div class="dropdown">
            <a href="#">Features ▼</a>
            <div class="dropdown-content">
                <a href="../realtime_weather_project/index2.php">Weather Updates</a>
                <a href="../CROPRECOMENDATION/index1.php">Crop Recommendation</a>
            </div>
        </div>

        <div id="google_element"></div>
        <a href="#">Notification <i class="fi fi-rs-bell"></i></a>
        <a href="../farmer/profile.php" class="profile-icon"> Profile <i class="fi fi-rr-user"></i></a>
    </nav>
</header>

<style>
/* Basic dropdown styling */
.dropdown {
    display: inline-block;
    position: relative;
}

.dropdown-content {
    display: none;
    position: absolute;
    background: black;
    border: 1px solid #ccc;
    min-width: 120px;
}

.dropdown-content a {
    display: block;
    padding: 8px;
    text-decoration: none;
    color: black;
}

.dropdown:hover .dropdown-content {
    display: block;
}
</style>

    <div class="hero-section">
        <div class="hero-content">
            <h2><span>Discover</span> government schemes for you...</h2>
            <p>Find Personalized Schemes Based on Eligibility</p>
        </div>
    </div>

    <div class="head">
        <h2>Apply for Government Schemes</h2>
        <p>Select a scheme below to check eligibility and apply</p>
    </div>
    <script src="https://cdn.botpress.cloud/webchat/v2.2/inject.js"></script>
    <script src="https://files.bpcontent.cloud/2025/03/22/22/20250322221348-N1BQQ8PV.js"></script>
    <!-- 📌 Scheme Cards (Dynamic Data) -->
    <div class="scheme-container">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="scheme-block">
                        <div class="scheme-image">
                            <img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['scheme_name']) . '">
                        </div>
                        <div class="scheme-text">
                            <h3 class="scheme-title">' . htmlspecialchars($row['scheme_name']) . '</h3>
                            <p>' . htmlspecialchars($row['description']) . '</p>
                            <p><strong>Eligibility:</strong> ' . htmlspecialchars($row['eligibility']) . '</p>
                            <p><strong>Benefit:</strong> ' . htmlspecialchars($row['benefits']) . '</p>
                            <a href="prio_reg.php" class="apply-btn">Apply Now</a>
                        </div>
                    </div>';
            }
        } else {
            echo "<p>No schemes available at the moment.</p>";
        }
        
        ?>
    </div>

    <script>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement(
                { pageLanguage: 'en', includedLanguages: 'en,hi,mr,ta,te,kn,gu,pa,bho,ml', layout: google.translate.TranslateElement.InlineLayout.SIMPLE },
                'google_element'
            );
        }
    </script>

</body>
</html>

