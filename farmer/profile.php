<?php
session_start();
include "../db.php"; // Ensure correct path to your database connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../registration/login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get logged-in user ID

// Fetch user details from database
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc() ?? []; // Default to empty array if no user found

// Handle old users who have 'name' but not 'first_name' and 'last_name'
if (!isset($user['first_name']) || empty($user['first_name'])) {
    $user['first_name'] = $user['name'] ?? ''; // Assign old 'name' field as 'first_name'
}

// Ensure last_name is not overwritten if it exists
if (!isset($user['last_name'])) {
    $user['last_name'] = ''; // Set only if it doesn't exist
}


// Ensure all fields exist in $user to prevent warnings
$default_fields = [
    'first_name' => '', 'last_name' => '', 'email' => '', 'mobile' => '',
    'address' => '', 'gender' => '', 'dob' => '', 'language' => '',
    'linkedin' => '', 'twitter' => ''
];

$user = array_merge($default_fields, $user);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $mobile = $_POST['mobile'] ?? ''; // Use mobile instead of phone
    $address = $_POST['address'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $language = $_POST['language'] ?? '';
    $linkedin = $_POST['linkedin'] ?? '';
    $twitter = $_POST['twitter'] ?? '';

    // Update user details in database
    $update_query = "UPDATE users SET name=?, last_name=?, mobile=?, address=?, gender=?, dob=?, language=?, linkedin=?, twitter=? WHERE id=?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssssssi", $first_name, $last_name, $mobile, $address, $gender, $dob, $language, $linkedin, $twitter, $user_id);    
    
    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile.');</script>";
    }
}
?>
<?php include "../assets/header.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriculture Profile | LinkedIn Style</title>
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>
<body>

<div class="profile-container">
    <!-- Left Section: Profile Picture & Basic Info -->
    <div class="profile-left">
        <div class="cover-image">
            <img src="https://images.unsplash.com/photo-1655130944329-b3a63166f6b5?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTh8fGZlcnRpbGl6ZXJzfGVufDB8fDB8fHww" alt="Cover Image">
        </div>
        <div class="profile-info">
            <img src="https://img.freepik.com/free-vector/user-blue-gradient_78370-4692.jpg" alt="User Picture" class="profile-pic">
            <h2><?php echo htmlspecialchars($user['name'] . ' ' . $user['last_name']); ?></h2>
        </div>
    </div>
    <script src="https://cdn.botpress.cloud/webchat/v2.2/inject.js"></script>
    <script src="https://files.bpcontent.cloud/2025/03/22/22/20250322221348-N1BQQ8PV.js"></script>
    <!-- Right Section: User Information -->
    <div class="profile-right">
        <h3>Personal Information</h3>
        <form method="POST">
            <div class="profile-fields">
                <div class="field-group">
                    <div class="field">
                        <label>First Name</label>
                        <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                    </div>
                    <div class="field">
                        <label>Last Name</label>
                        <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>">
                    </div>
                </div>
                <div class="field-group">
                    <div class="field">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                    </div>
                    <div class="field">
                        <label>Mobile</label> <!-- Updated to Mobile -->
                        <input type="text" name="mobile" value="<?php echo htmlspecialchars($user['mobile']); ?>">
                    </div>
                </div>
                <div class="field-group">
                    <div class="field">
                        <label>Address</label>
                        <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>">
                    </div>
                    <div class="field">
                        <label>Gender</label>
                        <select name="gender">
                            <option value="">Select Gender</option>
                            <option value="Male" <?php if ($user['gender'] == 'Male') echo "selected"; ?>>Male</option>
                            <option value="Female" <?php if ($user['gender'] == 'Female') echo "selected"; ?>>Female</option>
                            <option value="Other" <?php if ($user['gender'] == 'Other') echo "selected"; ?>>Other</option>
                        </select>
                    </div>
                </div>
                <div class="field-group">
                    <div class="field">
                        <label>Date of Birth</label>
                        <input type="date" name="dob" value="<?php echo htmlspecialchars($user['dob']); ?>">
                    </div>
                    <div class="field">
                        <label>Language</label>
                        <input type="text" name="language" value="<?php echo htmlspecialchars($user['language']); ?>">
                    </div>
                </div>
                <div class="field-group">
                    <div class="field">
                        <label>LinkedIn</label>
                        <input type="text" name="linkedin" value="<?php echo htmlspecialchars($user['linkedin']); ?>">
                    </div>
                    <div class="field">
                        <label>Twitter</label>
                        <input type="text" name="twitter" value="<?php echo htmlspecialchars($user['twitter']); ?>">
                    </div>
                </div>
            </div>
            <button type="submit" class="save-btn">Save Changes</button>
            <a href="../registration/logout.php">
    <button type="button">Logout</button>
</a>
        </form>
    </div>
</div>

</body>
</html>
