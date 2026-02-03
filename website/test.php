<?php
// ===== TEST PHP & MYSQL IN XAMPP =====

// 1️⃣ Test PHP
echo "<h2>PHP Test</h2>";
echo "✅ PHP is working!<br><br>";

// 2️⃣ Test MySQL Connection
$servername = "localhost";
$username = "root";
$password = ""; // Put your MySQL root password here
$database = "mysql"; // default database to test connection

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    echo "<h3 style='color:red;'>MySQL Connection Failed!</h3>";
    echo "Error: " . $conn->connect_error . "<br>";
} else {
    echo "<h3 style='color:green;'>✅ MySQL Connection Successful!</h3>";
}

// 3️⃣ Simple query test
$result = $conn->query("SHOW DATABASES");
if ($result) {
    echo "<strong>Databases on this server:</strong><br>";
    while ($row = $result->fetch_assoc()) {
        echo "- " . $row['Database'] . "<br>";
    }
} else {
    echo "Could not fetch databases.<br>";
}

// Close connection
$conn->close();
?>
