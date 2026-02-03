<?php
// ===== Hardcoded Login for Demo =====
session_start();

$correctUser = "student";
$correctPass = "12345";

$errorMessage = "";

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: test1.php");
    exit;
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    if ($user === $correctUser && $pass === $correctPass) {
        $_SESSION['loggedin'] = true;
        $_SESSION['user'] = $user;
        header("Location: test3.php");
        exit;
    } else {
        $errorMessage = "❌ Invalid Username or Password";
    }
}

// Check if logged in
$loggedIn = $_SESSION['loggedin'] ?? false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>System GUI Demo</title>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: #f0f2f5;
}

/* ===== Login Page ===== */
.login-page {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: linear-gradient(135deg, #74ABE2, #5563DE);
    color: #fff;
}
.login-box {
    background: rgba(0,0,0,0.6);
    padding: 30px;
    border-radius: 15px;
    width: 300px;
    text-align: center;
}
input[type="text"], input[type="password"] {
    width: 90%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 8px;
    border: none;
    transition: 0.3s;
}
input[type="text"]:focus, input[type="password"]:focus {
    outline: none;
    box-shadow: 0 0 10px #fff;
}
input[type="submit"] {
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    background-color: #00ff99;
    color: #000;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}
input[type="submit"]:hover {
    background-color: #00cc77;
}
.error-message {
    color: red;
    margin-top: 10px;
    font-weight: bold;
}

/* ===== Dashboard Page ===== */
.dashboard {
    display: flex;
    height: 100vh;
}
.sidebar {
    width: 200px;
    background-color: #222;
    color: #fff;
    padding-top: 20px;
    flex-shrink: 0;
}
.sidebar h2 {
    text-align: center;
    margin-bottom: 20px;
}
.sidebar a {
    display: block;
    color: #fff;
    padding: 10px 20px;
    text-decoration: none;
    margin: 5px 0;
    border-left: 4px solid transparent;
    transition: 0.3s;
}
.sidebar a:hover {
    background-color: #333;
    border-left: 4px solid #00ff99;
}
.main-content {
    flex-grow: 1;
    padding: 20px;
}
.main-content h1 {
    color: #333;
}
.card {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 15px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.logout {
    color: #ff4d4d;
    text-align: center;
    margin-top: 20px;
    display: block;
}
</style>
</head>
<body>

<?php if (!$loggedIn): ?>
<div class="login-page">
    <div class="login-box">
        <h2>Login</h2>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" value="Login">
        </form>
        <?php if ($errorMessage) echo "<div class='error-message'>$errorMessage</div>"; ?>
    </div>
</div>
<?php else: ?>
<div class="dashboard">
    <div class="sidebar">
        <h2>System GUI</h2>
        <a href="#">Dashboard</a>
        <a href="#">Network</a>
        <a href="#">Users</a>
        <a href="#">Settings</a>
        <a href="?logout=1" class="logout">Logout</a>
    </div>
    <div class="main-content">
        <h1>Welcome, <?php echo $_SESSION['user']; ?>!</h1>
        <div class="card">
            <h3>System Status</h3>
            <p>All systems are running normally.</p>
        </div>
        <div class="card">
            <h3>Network Info</h3>
            <p>IP Address: 192.168.1.1</p>
            <p>Connected Devices: 5</p>
        </div>
        <div class="card">
            <h3>Quick Actions</h3>
            <button onclick="alert('Rebooting system...')">Reboot</button>
            <button onclick="alert('Settings saved!')">Save Settings</button>
        </div>
    </div>
</div>
<?php endif; ?>

</body>
</html>
