<?php

// Start session only if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: ../registration/login.php");
    exit();
}
?>

<header class="header">
    <h2>AgriConnect</h2>

    <input type="text" placeholder="Search..." class="search-bar">

    <nav>
        <a href="../dashboard/farmer_dashboard.php">Home</a>
        <a href="../farmer/schemes.php">Scheme</a>
        <a href="#">Community</a>
        <a href="#">Workers</a>
        <a href="#">Products</a>

        <!-- 🔽 Translator Dropdown -->
        <div id="google_element"></div>

        <a href="#">Notification <i class="fi fi-rs-bell"></i></a>
        <a href="profile.php" class="profile-icon">Profile <i class="fi fi-rr-user"></i></a>

    </nav>
</header>

<style>
       * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            height: 100%;
            background: #f4f4f4;
            color: #333;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: #253A25;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
            
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* 🧭 NAVIGATION LINKS */
        .header nav {
            display: flex;
            align-items: center;
        }

        .header nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
            transition: color 0.3s ease;
            position: relative;
        }

        .header nav a:hover {
            color: #9ACC5C;
        }

        /* 🔍 SEARCH BAR */
        .search-bar {
            padding: 8px;
            border: 2px solid #9ACC5C;
            border-radius: 5px;
            width: 160px;
            transition: all 0.3s ease-in-out;
            outline: none;
        }

        .search-bar:focus {
            width: 250px;
            border-color: #BCD99A;
            box-shadow: 0 0 8px rgba(156, 204, 92, 0.5);
        }

        /* 📌 NAVBAR ICONS */
        .icons {
            display: flex;
            align-items: center;
        }

        .icons span {
            font-size: 20px;
            margin-left: 15px;
            cursor: pointer;
            transition: transform 0.2s ease-in-out;
        }

        /* 🌎 TRANSLATOR DROPDOWN */
        .dropdown {
            position: relative;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            width: 120px;
            top: 25px;
            left: 0;
            z-index: 1000;
        }

        .dropdown-content a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: black;
        }

        .dropdown-content a:hover {
            background: #f1f1f1;
        }

        /* 🏆 TRANSLATOR CONTAINER */
        .translator-container {
            display: flex;
            align-items: center;
            background: #253A25;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
        }

        .translator-container:hover {
            background: #9ACC5C;
        }

        /* 🎨 GOOGLE TRANSLATE CUSTOMIZATION */
        #google_element {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 5px 10px;
            background: transparent;
            border-radius: 5px;
        }

        .goog-te-gadget-simple {
            background: transparent !important;
            border: none !important;
            display: flex !important;
            align-items: center !important;
        }

        .goog-te-gadget span,
        .goog-logo-link {
            display: none !important;
        }

        .goog-te-gadget select {
            background: #253A25;
            color: white;
            border: 2px solid #9ACC5C;
            padding: 8px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            outline: none;
        }

        .goog-te-gadget select:hover {
            background: #9ACC5C;
            color: #253A25;
        }
    </style>
