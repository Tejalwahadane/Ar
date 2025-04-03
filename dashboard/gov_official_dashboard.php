<?php
session_start();
include '../db.php'; // Database connection

// Fetch posts from the database
$query = "SELECT * FROM gov_posts ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Government Officer Dashboard</title>
    <link rel="stylesheet" href="../assets/css/gov_dashboard_style.css">

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
            /* Adding some space for navbar */
        }

        /* 🌿 Navbar */
        .navbar {
            background: #253a25;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .navbar .logo {
            font-size: 22px;
            font-weight: bold;
        }

        .navbar nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        .navbar nav a:hover {
            color: #9acc5c;
        }

        /* 📌 Main Container */
        .container {
            display: flex;
            justify-content: center;
            gap: 30px;
            width: 90%;
            max-width: 1200px;
            margin: 20px auto 20px;
            /* Adjusted margin for spacing */
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
            /* Ensuring posts don’t get too squished */
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

        /* 📊 Government Schemes (Right Sidebar) */
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

            .navbar {
                padding: 12px 20px;
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

            .navbar nav a {
                font-size: 14px;
                margin: 0 10px;
            }

            .schemes-sidebar h3 {
                font-size: 18px;
            }

            .schemes-sidebar ul li {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

    <!-- Navigation Bar -->
<header class="navbar">
    <div class="logo">KishanSetu</div>
    <nav>
        <a href="gov_official_dashboard.php">Home</a>
        <a href="../gov/add_schemes.php">Government Schemes</a>
        <a href="../gov/priority.php">Applicants</a>
        <a href="../dashboard/experts_community.php">Community</a>
        <div id="google_element"></div>
        <a href="../registration/logout.php" class="logout-btn">Logout</a>
    </nav>
</header>

    <!-- Main Container -->
    <div class="container">
        <!-- Main Dashboard Section -->
        <section class="main-content">
            <h2>Welcome, Government Officer</h2>
            <p>Monitor and manage government schemes efficiently.</p>

            <!-- Post Box -->
            <div class="post-box">
                <form action="../gov/post_handler.php" method="post" enctype="multipart/form-data">
                    <textarea name="post_content" placeholder="Write your Post here..." required></textarea><br>
                    <input type="file" name="image" accept="image/*"><br>
                    <button type="submit">Post</button>
                </form>
            </div>

            <!-- Display Posts -->
            <h3>Recent Posts</h3>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <?php
                // Check if the post has an image
                $hasImage = !empty($row['image']);

                // Dynamic CSS classes based on conditions
                $postClass = $hasImage ? 'post-with-image' : 'post-no-image';
                ?>
                <div class="post <?php echo $postClass; ?>">
                    <h4>Government Officer</h4>
                    <p><?php echo htmlspecialchars($row['content']); ?></p>
                    <?php if ($hasImage): ?>
                        <img src="../uploads/<?php echo $row['image']; ?>" width="200">
                    <?php endif; ?>
                    <small>Posted on: <?php echo $row['created_at']; ?></small>
                </div>
            <?php endwhile; ?>
        </section>

        <!-- Government Schemes Sidebar -->
        <aside class="schemes-sidebar">
            <h3>Active Government Schemes</h3>
            <ul>
                <?php
                $query = "SELECT scheme_name, description FROM schemes ORDER BY start_date DESC LIMIT 5";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<li><strong>" . $row['scheme_name'] . "</strong>: " . substr($row['description'], 0, 50) . "...</li>";
                    }
                } else {
                    echo "<li>No active schemes available.</li>";
                }
                ?>
            </ul>
        </aside>
    </div>

</body>

</html>