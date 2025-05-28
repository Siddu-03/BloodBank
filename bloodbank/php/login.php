<?php
session_start();

$conn = new mysqli("localhost", "root", "Siddu@1206", "blood_bank");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $role = $_POST["role"];

    if (empty($email) || empty($password)) {
        echo "<script>alert('Please enter both username and password.'); window.location.href='login.php';</script>";
        exit;
    }

    $roleMap = [
        "donor" => "Donor",
        "hospital" => "Hospital",
        "bloodbank" => "Admin"
    ];

    if (!isset($roleMap[$role])) {
        echo "<script>alert('Invalid role.'); window.location.href='login.php';</script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM MobileUser WHERE Email = ? AND Role = ?");
    $dbRole = $roleMap[$role];
    $stmt->bind_param("ss", $email, $dbRole);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!($result && $result->num_rows === 1)) {
        echo "<script>alert('User not found with email: $email and role: $dbRole'); window.location.href='login.php';</script>";
        exit;
    }

    $user = $result->fetch_assoc();

    // Compare passwords - IMPORTANT: This assumes passwords are stored in plain text.
    // For production, use password_hash and password_verify for security.
    if ($password === $user["PasswordHash"]) {
        $phone = $user["PhoneNumber"];

        $roleTable = [
            "donor" => ["table" => "Donor", "column" => "Contact"],
            "hospital" => ["table" => "Hospital", "column" => "Contact"],
            "bloodbank" => ["table" => "BloodCenter", "column" => "Contact"]
        ];
        $info = $roleTable[$role];
        $verifyStmt = $conn->prepare("SELECT * FROM {$info['table']} WHERE {$info['column']} = ?");
        $verifyStmt->bind_param("s", $phone);
        $verifyStmt->execute();
        $verifyResult = $verifyStmt->get_result();

        if ($verifyResult && $verifyResult->num_rows === 1) {
            // Set session variables
           $_SESSION["user_id"] = $user["UserID"];
$_SESSION["user_name"] = $user["Name"];
$_SESSION["user_email"] = $user["Email"];         // ✅ Add this line
$_SESSION["user_phone"] = $user["PhoneNumber"];   // ✅ Add this line
$_SESSION["user_role"] = $user["Role"];


            // Redirect based on role
            switch ($role) {
                case 'donor':
                    header("Location: donor-dashboard.php");
                    exit;
                case 'hospital':
                    header("Location: hospital-dashboard.php");
                    exit;
                case 'bloodbank':
                    header("Location: bloodbank-dashboard.php");
                    exit;
            }
        } else {
            echo "<script>alert('Phone number {$phone} not found in {$info['table']}'); window.location.href='login.php';</script>";
            exit;
        }

    } else {
        echo "<script>alert('Incorrect password.'); window.location.href='login.php';</script>";
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BloodVault - Login</title>
    <link rel="stylesheet" href="login-style.css">
</head>
<body>
    <div class="login-page-wrapper">
        <div class="particles-background" id="particles-js"></div>

        <header>
            <h1>BloodVault Login</h1>
            <div class="wave-container">
                <div class="wave"></div>
            </div>
        </header>

        <main class="login-main">
            <div class="login-container">
                <div class="blood-drop drop-1"></div>
                <div class="blood-drop drop-2"></div>

                <div class="login-header">
                    <h2>Welcome Back</h2>
                    <p>Please enter your credentials to continue</p>
                </div>

                <div id="roleButtons">
                    <button type="button" class="role-btn" data-role="bloodbank">Blood Bank</button>
                    <button type="button" class="role-btn active" data-role="hospital">Hospital</button>
                    <button type="button" class="role-btn" data-role="donor">Donor</button>
                </div>

                <form id="login-form" method="POST" action="login.php">
                    <input type="hidden" name="role" id="role" value="hospital">

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter your username" required>
                        <span class="input-icon">👤</span>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <span class="input-icon">🔒</span>
                    </div>

                    <div class="login-options">
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember" class="checkmark"></label>
                            <span>Remember me</span>
                        </div>
                        <a href="forgot-password.html">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn-login">LOGIN</button>
                </form>

                <a href="register.php" class="home-link">
                    <span>Don't have an account? Register here</span>
                </a>
                <a href="index.php" class="home-link">
                    <span class="home-link-icon">←</span>
                    <span>Back to Home</span>
                </a>
            </div>
        </main>

        <div class="notification" id="notification">Login successful! Redirecting...</div>

        <footer>
            <p>© 2025 BloodVault <span class="heart-icon">❤</span> All Rights Reserved</p>
        </footer>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleButtons = document.querySelectorAll('.role-btn');
        const roleInput = document.getElementById('role');

        roleButtons.forEach(button => {
            button.addEventListener('click', function () {
                roleButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                roleInput.value = this.getAttribute('data-role');
            });
        });
    });
    </script>
    <script src="js/app.js"></script>
</body>
</html>
