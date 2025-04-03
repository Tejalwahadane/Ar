<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Agriculture</title>
    <link rel="stylesheet" href="../assets/css/registration.css">
</head>
<body>

<div class="container">
    <div class="left-side">
        <h2>Grow with Nature</h2>
        <p>Empowering farmers with technology</p>
    </div>

    <div class="right-side">
        <header>
            <h1>Create an Account</h1>
            <p>Join us today!</p>
        </header>

        <form action="register.php" method="POST">
            <div class="form-row">
                <div class="input-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" required>
                </div>
            </div>

            <div class="input-group full-width">
                <label for="mobile">Mobile No</label>
                <input type="tel" name="mobile" required>
            </div>

            <div class="input-group full-width">
                <label for="email">Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="input-group full-width">
                <label for="role">Register As</label>
                <select name="role" required id="reg_as">
                    <option value="farmer">Farmer</option>
                    <option value="gov_official">Government Official</option>
                    <option value="expert">Expert</option>
                    <option value="worker">Daily Wage Worker</option>
                </select>
            </div>

            <div class="input-group full-width">
                <label for="password">Password</label>
                <input type="password" name="password" required>
            </div>

            <!-- Fifth Row: Confirm Password -->
            <div class="input-group full-width">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" placeholder="Confirm your password">
            </div>

            <button type="submit">Register</button>
            <p class="signup-text">Already have an account? <a href="login.php">Sign in</a></p>

            <script>
    document.querySelector("form").addEventListener("submit", function (e) {
        let password = document.querySelector('input[name="password"]').value;
        let confirmPassword = document.querySelector('#confirm-password').value;

        if (password !== confirmPassword) {
            alert("Passwords do not match!");
            e.preventDefault();
        }
    });
</script>

        </form>
    </div>
</div>

</body>
</html>
