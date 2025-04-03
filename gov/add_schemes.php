<?php
include('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $scheme_name = mysqli_real_escape_string($conn, $_POST['scheme_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $eligibility = mysqli_real_escape_string($conn, $_POST['eligibility']);
    $benefits = mysqli_real_escape_string($conn, $_POST['benefits']);

    // Image Upload Handling
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

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Insert data into the database
        $sql = "INSERT INTO schemes (scheme_name, description, eligibility, benefits, image) 
                VALUES ('$scheme_name', '$description', '$eligibility', '$benefits', '$target_file')";

        if (mysqli_query($conn, $sql)) {
            // Redirect after form submission to reload the page without the POST data
            header("Location: add_schemes.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error uploading the image.";
    }
}
?>


<style>
    /* Reset styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    /* Body Styling */
    body {
        background: #f4f4f4;
        color: #333;
        /* Optional color for the body text */
    }

    /* Sticky Navbar */
    .navbar {
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

    /* Navbar Logo */
    .navbar .logo {
        font-size: 22px;
        font-weight: 600;
    }

    /* Navbar Links */
    .navbar nav a {
        color: white;
        text-decoration: none;
        margin: 0 15px;
        font-weight: bold;
        transition: color 0.3s;
    }

    /* Navbar Links Hover Effect */
    .navbar nav a:hover {
        color: #9ACC5C;
    }

    /* General Form Styling */
    form {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 100px auto;
        /* Adjusted margin for better positioning */
        font-family: 'Poppins', sans-serif;
        border: 1px solid #ccc;
        /* Light border around form */
    }

    /* Form Header */
    form h3 {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
        color: #253A25;
    }

    /* Input Fields & Textarea Styling */
    form input[type="text"],
    form textarea,
    form input[type="file"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        box-sizing: border-box;
    }

    /* Focused Input Fields & Textarea */
    form input[type="text"]:focus,
    form textarea:focus,
    form input[type="file"]:focus {
        border-color: #9ACC5C;
        outline: none;
    }

    /* Textarea Specific Styling */
    form textarea {
        resize: none;
        /* Disabling resizing to maintain consistent layout */
    }

    /* Submit Button */
    form button {
        background-color: #253A25;
        color: white;
        border: none;
        padding: 12px 20px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        width: 100%;
    }

    /* Submit Button Hover Effect */
    form button:hover {
        background-color: #9ACC5C;
    }

    /* Placeholder Text Styling */
    form input::placeholder,
    form textarea::placeholder {
        font-style: italic;
        color: #aaa;
    }

    /* Responsive Design for Mobile */
    @media (max-width: 768px) {
        form {
            padding: 20px;
            /* Reduced padding for smaller screens */
        }

        form input[type="text"],
        form textarea,
        form input[type="file"],
        form button {
            font-size: 14px;
            /* Adjust font size on smaller screens */
        }
    }
</style>

<!-- Navigation Bar -->
<header class="navbar">
    <div class="logo">KishanSetu</div>
    <nav>
        <a href="../dashboard/gov_official_dashboard.php">Home</a>
        <a href="../gov/add_schemes.php">Government Schemes</a>
        <a href="../gov/priority.php">Applicants</a>
        <a href="../dashboard/experts_community.php">Community</a>
        <div id="google_element"></div>
        <a href="../registration/logout.php" class="logout-btn">Logout</a>
    </nav>
</header>
<!-- HTML Form -->
<form action="../gov/add_schemes.php" method="post" enctype="multipart/form-data">
    <h3>Add a New Scheme</h3> <!-- Header added here -->
    <input type="text" name="scheme_name" placeholder="Scheme Name" required><br>
    <textarea name="description" placeholder="Description" required></textarea><br>
    <textarea name="eligibility" placeholder="Eligibility" required></textarea><br>
    <textarea name="benefits" placeholder="Benefits" required></textarea><br>
    <input type="file" name="image" accept="image/*" required><br>
    <button type="submit">Add Scheme</button>
</form>

<script>
        document.getElementById("translator-btn").addEventListener("click", function (e) {
            e.preventDefault();
            document.getElementById("translator-dropdown").style.display = "block";
        });

        window.onclick = function (event) {
            if (!event.target.matches('#translator-btn')) {
                document.getElementById("translator-dropdown").style.display = "none";
            }
        };
    </script>
    <div id="google_element"></div>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement(
                {
                    pageLanguage: 'en',
                    includedLanguages: 'en,hi,mr,ta,te,kn,gu,pa,bho,ml', // Restrict to selected languages
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                },
                'google_element'
            );
        }
    </script>

    <script type="text/javascript"
        src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
        </script>

    <script>
        function removeGoogleTranslateToolbar() {
            let observer = new MutationObserver(() => {
                let translateBanner = document.querySelector(".goog-te-banner-frame");
                if (translateBanner) translateBanner.remove();
            });
            observer.observe(document.body, { childList: true, subtree: true });
        }

        window.addEventListener("load", removeGoogleTranslateToolbar);

        // Remove Google Translate Toolbar
        function removeGoogleTranslateToolbar() {
            let observer = new MutationObserver(() => {
                let translateBanner = document.querySelector(".goog-te-banner-frame");
                if (translateBanner) translateBanner.remove();
            });
            observer.observe(document.body, { childList: true, subtree: true });
        }

        window.addEventListener("load", removeGoogleTranslateToolbar);

    </script>