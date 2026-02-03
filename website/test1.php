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

// Initialize variables
$errorMessage = "";
$loginSuccess = false;

// Handle login POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$user]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($pass, $row['password'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['user'] = $row['username'];
        $_SESSION['loginSuccess'] = true; // used for redirect animation
        header("Location: test1.php"); // redirect to self to prevent form resubmit
        exit();
    } else {
        $errorMessage = "❌ Invalid Username or Password";
    }
}

// Check if redirected after login
$loginSuccess = $_SESSION['loginSuccess'] ?? false;
unset($_SESSION['loginSuccess']);

// Include the HTML template
include "test1_template.php";
