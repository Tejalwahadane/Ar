<?php
// Start session to access user data
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Include the database connection
include('../db.php');

// Get the logged-in user's ID from the session
$user_id = $_SESSION['user_id'];

// Fetch user data from the database
$query = "SELECT * FROM users WHERE id = '$user_id' LIMIT 1";
$result = mysqli_query($conn, $query);

// Check if user data is fetched
if ($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
} else {
    echo "Error: User data could not be fetched.";
    exit();
}

// Handle post creation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the inputs
    $post_content = mysqli_real_escape_string($conn, $_POST['post_content']);
    $image_path = '';

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../uploads/";
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Allow only certain image types
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = $image_name; // Store the image path
            } else {
                echo "Error uploading image.";
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG, GIF are allowed.";
        }
    }

    // Insert the post into the database
    $query = "INSERT INTO posts (user_id, content, image, created_at) 
              VALUES ('$user_id', '$post_content', '$image_path', NOW())";
    if (mysqli_query($conn, $query)) {
        header("Location: farmer_dashboard.php"); // Redirect to the dashboard after posting
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Fetch all posts from the farmers (for display)
$post_query = "SELECT * FROM posts ORDER BY created_at DESC";
$post_result = mysqli_query($conn, $post_query);

// Fetch active farmer schemes
$scheme_query = "SELECT scheme_name, description FROM schemes ORDER BY start_date DESC LIMIT 5";
$scheme_result = mysqli_query($conn, $scheme_query);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgriConnect - Home</title>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/feed.css">
    <style>
        /* 🌾 General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background: #f8f9fa;
            color: #333;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow-x: hidden;
            padding-top: 80px;
        }

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

        /* 📌 Main Container */
        .container {
            display: flex;
            justify-content: center;
            gap: 30px;
            width: 90%;
            max-width: 1200px;
            margin: 20px auto 20px;
        }

        /* 🔹 Main Content */
        .main-content {
            flex: 2;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 2px 4px 20px rgba(0, 0, 0, 0.1);
            height: auto;
            overflow-y: auto;
            min-width: 300px;
        }

        .main-content h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #253a25;
        }

        /* 📝 Post Box */
        .post-box {
            background: #f0f3f4;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);
        }

        textarea {
            width: 100%;
            height: 120px;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 14px;
            margin-bottom: 15px;
        }

        input[type="file"] {
            margin-bottom: 15px;
        }

        button {
            background: #253a25;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
            font-size: 16px;
        }

        button:hover {
            background: #9acc5c;
        }

        /* 📌 Posts */
        .post {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 2px 4px 12px rgba(0, 0, 0, 0.1);
        }

        .post h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #253a25;
        }

        .post p {
            font-size: 15px;
            color: #444;
            margin-bottom: 15px;
        }

        .post img {
            width: 100%;
            border-radius: 5px;
            margin-top: 15px;
        }

        /* 📊 Farmer Schemes (Right Sidebar) */
        .schemes-sidebar {
            flex: 1;
            background: #9acc5c;
            padding: 25px;
            border-radius: 10px;
            height: fit-content;
            max-height: 500px;
            overflow-y: auto;
            box-shadow: 2px 4px 20px rgba(0, 0, 0, 0.1);
        }

        .schemes-sidebar h3 {
            font-size: 20px;
            margin-bottom: 15px;
            color: #253a25;
        }

        .schemes-sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .schemes-sidebar ul li {
            padding: 12px 0;
            font-size: 16px;
            color: #253a25;
            border-bottom: 1px solid #ddd;
        }

        .schemes-sidebar ul li:last-child {
            border-bottom: none;
        }

        /* 🌍 Responsive Design */
        @media (max-width: 1024px) {
            .container {
                flex-direction: column;
                align-items: center;
            }

            .schemes-sidebar {
                width: 100%;
                margin-top: 20px;
            }


            .post-box {
                padding: 15px;
            }

            .main-content h2 {
                font-size: 22px;
            }

            button {
                padding: 10px 15px;
                font-size: 14px;
            }
        }

        @media (max-width: 768px) {
            .navbar .logo {
                font-size: 18px;
            }

            .post-box textarea {
                height: 100px;
            }
        }
    </style>
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
        <a href="../dashboard/index.html">Products</a>
        <a href="../realtime_weather_project/index2.php">Weather Updates</a>
        <a href="../CROPRECOMENDATION/index1.php">Crop Recommendation</a>

        <div id="google_element"></div>
        <a href="../farmer/profile.php" class="profile-icon"> Profile <i class="fi fi-rr-user"></i></a>
    </nav>
</header>

    <!-- Main Content Area -->
    <div class="container">
        <!-- Farmer's Post Area -->
        <div class="main-content">
            <h2>Create a Post</h2>

            <!-- Post Creation Form -->
            <form method="POST" enctype="multipart/form-data">
                <div class="post-box">
                    <textarea name="post_content" placeholder="Share your thoughts..." required></textarea>
                    <input type="file" name="image" accept="image/*" />
                    <button type="submit">Post</button>
                </div>
            </form>

            <!-- Display Farmer Posts -->
            <?php if ($post_result && mysqli_num_rows($post_result) > 0): ?>
                <?php while ($post = mysqli_fetch_assoc($post_result)): ?>
                    <div class="post">
                        <h3>Post by Farmer</h3>
                        <p><?= nl2br($post['content']) ?></p>
                        <?php if ($post['image']): ?>
                            <img src="../uploads/<?= $post['image'] ?>" alt="Post Image" />
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No posts yet.</p>
            <?php endif; ?>
        </div>


    </div>

</body>

</html>