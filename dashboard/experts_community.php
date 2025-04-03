<?php
session_start();
include "../db.php"; // Ensure correct path to the database connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../registration/login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get logged-in user ID

// Fetch only `username` from the database
$query = "SELECT username FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$username = $user['username'] ?? 'Unknown User'; // Fallback to prevent errors

// Function to fetch username from the database
function getUsername($id, $conn)
{
    $username = "";
    $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($username);
        $stmt->fetch();
        $stmt->close();
    }
    return $username ?: null; // Return null if no username found
}

// Ensure username is set before proceeding
if (empty($username)) {
    die("Error: Username not set in session.");
}

// Handle chat message submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["message"], $_POST["expert_id"])) {
    $message = trim($_POST["message"]);
    $expert_id = intval($_POST["expert_id"]);

    // Get expert's username from the database
    $expert_name = getUsername($expert_id, $conn);

    // Ensure data is valid before inserting
    if (!empty($message) && $expert_id > 0 && $user_id > 0 && $expert_name) {
        $stmt = $conn->prepare("INSERT INTO chat_messages (expert_id, user_id, expert_name, user_name, message)
VALUES (?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("iisss", $expert_id, $user_id, $expert_name, $username, $message);
            $stmt->execute();
            $stmt->close();
        } else {
            die("Error: Failed to insert message.");
        }
    } else {
        die("Error: Invalid data provided.");
    }
    exit;
}

// Fetch chat messages
if (isset($_GET["expert_id"])) {
    $expert_id = intval($_GET["expert_id"]);
    $expert_name = getUsername($expert_id, $conn);

    if ($expert_name) {
        $stmt = $conn->prepare("SELECT user_name, message FROM chat_messages WHERE expert_id = ? AND user_id = ? ORDER BY
timestamp ASC");
        if ($stmt) {
            $stmt->bind_param("ii", $expert_id, $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // Display chat messages safely
            while ($row = $result->fetch_assoc()) {
                echo "<p><strong>" . htmlspecialchars($row['user_name']) . ":</strong> " . htmlspecialchars($row['message']) . "</p>";
            }
            $stmt->close();
        } else {
            die("Error: Failed to fetch messages.");
        }
    } else {
        die("Error: Expert not found.");
    }
    exit;
}
?>








<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expert Chat</title>

    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .head1 {
            background: #253A25;
            color: white;

            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;

            height: 50px;

            z-index: 1000;

            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .head1 h2 {
            padding-left: 20px;
        }

        /* 🧭 NAVIGATION LINKS */
        .head1 nav {

            display: flex;
            align-items: center;
        }

        .head1 nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
            transition: color 0.3s ease;
            position: relative;
        }

        .head1 nav a:hover {
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

        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f7;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }




        .container {
            text-align: center;
            width: 95%;
            max-width: 1400px;
            padding: 20px;
        }

        header {
            background: linear-gradient(135deg, #9ACC5C, #253A25);
            color: white;
            padding: 30px;
            height: 90vh;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        header ul {
            list-style-type: none;
            padding: 0;
        }

        header ul li {
            margin: 10px 0;
            font-weight: bold;
        }

        .expert-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            width: 100%;
        }

        .expert-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
        }

        .expert-card:hover {
            transform: translateY(-5px);
        }

        .chat-btn {
            background: #9ACC5C;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 16px;
        }

        .chat-btn:hover {
            background: #253A25;
        }

        .chat-box {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 400px;
            height: 500px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            flex-direction: column;
        }

        .chat-header {
            background: #253A25;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-body {
            padding: 15px;
            min-height: 350px;
            overflow-y: auto;
        }

        .chat-footer {
            padding: 15px;
            display: flex;
            gap: 5px;
        }

        .chat-footer input {
            flex: 1;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .chat-footer button {
            background: #9ACC5C;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .chat-footer button:hover {
            background: #253A25;
        }
    </style>
</head>

<body>

    <header class="head1">
        <h2>AgriConnect</h2>

        <input type="text" placeholder="Search..." class="search-bar">

        <nav>
        <a href="../dashboard/farmer_dashboard.php">Home</a>
        <a href="../farmer/schemes.php">Scheme</a>
        <a href="../dashboard/experts_community.php">Community</a>
        <a href="../farmer/index3.html">Workers</a>
        <a href="../dashboard/index.html">Products</a>
        <a href="../realtime_weather_project/index2.php">Weather Updates</a>
        <a href="../CROPRECOMENDATION/index1.php">Crop Recommendation</a>

        <div id="google_element"></div>
        <a href="../farmer/profile.php" class="profile-icon"> Profile <i class="fi fi-rr-user"></i></a>
    </nav>
    </header>

    <div class="container-1">
        <div class="why-choose-section">
            <h1 class="animated-text">Why Choose Our Experts?</h1>
            <p class="animated-text">Get guidance from industry leaders with years of experience in various domains.</p>
            <ul class="animated-text">
                <li>Expert advice from top professionals</li>
                <li>Personalized solutions for your needs</li>
                <li>Real-time interaction and consultation</li>
            </ul>
        </div>
    </div>

    <style>
        .why-choose-section h1 {
            font-size: 48px;
            font-weight: 700;
            color: #222;
            opacity: 0;
            animation: fadeInText 1.2s ease-in-out forwards;
        }



        /* 📝 Paragraph */
        .animated-text {
            font-size: 22px;
            color: #222;
            margin-top: 10px;
            opacity: 0;
            animation: fadeInText 1.5s ease-in-out forwards;
        }

        /* Ensure container-1 takes full height */
        .container-1 {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
            /* Full screen height */

            background: linear-gradient(135deg, #9ACC5C, #253A25);

        }



        /* Animated Text Styles */
        .why-choose-section h1,
        .why-choose-section p,
        .why-choose-section ul {
            opacity: 0;
            /* Initially hidden */
            transform: translateY(20px);
            /* Start off-screen */
            animation: fadeInUp 1s forwards;
            /* Apply the animation */
        }

        /* Apply staggered animation delays */
        .animated-text:nth-child(1) {
            animation-delay: 0.2s;
        }

        .animated-text:nth-child(2) {
            animation-delay: 0.4s;
        }

        .animated-text:nth-child(3) {
            animation-delay: 0.6s;
        }

        .animated-text li {
            list-style-type: none;
            margin: 10px 0;
        }

        /* Define the fadeInUp animation */
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
                /* Bring the text to its original position */
            }
        }
    </style>

    <script>
        // Optional: JavaScript to ensure the animation runs on page load
        window.addEventListener('load', function () {
            const elements = document.querySelectorAll('.animated-text');
            elements.forEach((element, index) => {
                element.style.animation = `fadeInUp 1s forwards ${index * 0.2}s`; // Stagger the animations
            });
        });
    </script>

    <div class="container">
        <h1>Meet Our Experts</h1>
        <div class="expert-list" id="expertList"></div>
    </div>

    <div id="chatBox" class="chat-box">
        <div class="chat-header">
            <span id="chatTitle">Chat</span>
            <button id="closeChat">&times;</button>
        </div>
        <div class="chat-body"></div>
        <div class="chat-footer">
            <input type="text" placeholder="Type a message...">
            <button>Send</button>
        </div>
    </div>

    <script>
        const userId = Math.floor(Math.random() * 1000); // Assign a random user ID
        const userName = "User" + userId;

        const experts = [
            { id: 1, name: "Dr. John Doe", expertise: "AI & Machine Learning", experience: "10 years" },
            { id: 2, name: "Jane Smith", expertise: "Cybersecurity", experience: "8 years" },
            { id: 3, name: "Michael Lee", expertise: "Blockchain Technology", experience: "7 years" },
            { id: 4, name: "Emily Johnson", expertise: "Data Science", experience: "6 years" },
            { id: 5, name: "Dr. Raj Patel", expertise: "Agricultural Science", experience: "15 years" },
            { id: 6, name: "Sophia Green", expertise: "Organic Farming", experience: "12 years" },
            { id: 7, name: "Liam Brown", expertise: "Soil Management", experience: "10 years" },
            { id: 8, name: "Olivia Adams", expertise: "Precision Agriculture", experience: "9 years" },

        ];

        const expertList = document.getElementById("expertList");
        let activeExpertId = null;
        let activeExpertName = null;

        experts.forEach(expert => {
            let expertCard = document.createElement("div");
            expertCard.classList.add("expert-card");
            expertCard.innerHTML = `
            <h2>${expert.name}</h2>
            <p><strong>Expertise:</strong> ${expert.expertise}</p>
            <p><strong>Experience:</strong> ${expert.experience}</p>
            <button class="chat-btn">Chat</button>
        `;
            expertCard.querySelector(".chat-btn").addEventListener("click", function () {
                activeExpertId = expert.id;
                activeExpertName = expert.name;
                document.getElementById("chatBox").style.display = "block";
                document.getElementById("chatTitle").innerText = `Chat with ${expert.name}`;
                loadMessages();
            });
            expertList.appendChild(expertCard);
        });

        document.getElementById("closeChat").addEventListener("click", () => {
            document.getElementById("chatBox").style.display = "none";
        });

        document.querySelector(".chat-footer button").addEventListener("click", function () {
            let messageInput = document.querySelector(".chat-footer input");
            let message = messageInput.value.trim();

            if (message && activeExpertId) {
                fetch("", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: new URLSearchParams({
                        message: message,
                        expert_id: activeExpertId,
                        user_id: userId,
                        expert_name: activeExpertName,
                        user_name: userName
                    })
                });

                messageInput.value = "";
                loadMessages();
            }
        });

        function loadMessages() {
            if (!activeExpertId) return;
            fetch(`?expert_id=${activeExpertId}&user_id=${userId}`)
                .then(response => response.text())
                .then(data => { document.querySelector(".chat-body").innerHTML = data; });
        }

        setInterval(loadMessages, 3000);

    </script>

</body>

</html>
<script src="https://cdn.botpress.cloud/webchat/v2.2/inject.js"></script>
<script src="https://files.bpcontent.cloud/2025/03/22/22/20250322221348-N1BQQ8PV.js"></script>