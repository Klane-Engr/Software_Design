<?php
session_start();

// Protect page
if (!isset($_SESSION['loggedin'])) {
    header("Location: test1.php");
    exit;
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: test1.php");
    exit;
}

// Variables for template
$username = $_SESSION['user'] ?? 'User';

// Load UI
include "dashboard_template.php";
