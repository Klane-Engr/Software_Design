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
        // Check if username exists
        $stmt = $pdo->prepare("SELECT 1 FROM users WHERE username = ?");
        $stmt->execute([$user]);

        if ($stmt->rowCount() > 0) {
            $error = "❌ Username already taken";
        } else {
            $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare(
                "INSERT INTO users (username, password) VALUES (?, ?)"
            );

            if ($stmt->execute([$user, $hashedPass])) {
                $success = "✅ Account created! You can now login.";
            } else {
                $error = "❌ Failed to create account. Try again.";
            }
        }
    }
}

// Load HTML template
include "test_create_template.php";
