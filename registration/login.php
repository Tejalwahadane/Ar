<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Agriculture</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>

<div class="container">
    <div class="left-side">
        <h2>Welcome Back</h2>
        <p>Please enter your details</p>
    </div>

    <div class="right-side">
        <form action="login_process.php" method="POST">
        <h2>Welcome Back</h2>
            <p>Please enter your details</p>

            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter your username" required>

            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit">Sign in</button>

            <p class="signup-text">Don't have an account? <a href="registration.php">Sign up</a></p>
        </form>
    </div>
</div>

</body>
</html>
