<?php
session_start();

// Database connection
$host = "localhost";
$dbname = "klane";
$dbuser = "root";
$dbpass = "";
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = trim($_POST['username'] ?? '');
    $pass = trim($_POST['password'] ?? '');
    $confirm = trim($_POST['confirm'] ?? '');

    if ($user === "" || $pass === "" || $confirm === "") {
        $error = "❌ All fields are required";
    } elseif ($pass !== $confirm) {
        $error = "❌ Passwords do not match";
    } elseif (strlen($pass) < 4) {
        $error = "❌ Password too short";
    } else {
        // Find user
        $stmt = $pdo->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->execute([$user]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            $error = "❌ Username not found";
        } elseif (password_verify($pass, $row['password'])) {
            $error = "❌ New password cannot be the same as the old password";
        } else {
            // Update password
            $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
            $update = $pdo->prepare(
                "UPDATE users SET password = ? WHERE username = ?"
            );
            $update->execute([$hashedPass, $user]);

            $success = "✅ Password updated! You can now login.";
        }
    }
}

// Load HTML template
include "forgot_template.php";
