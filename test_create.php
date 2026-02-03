<?php
session_start();

// Database connection
$host = "localhost";
$dbname = "klane";   // your database name
$dbuser = "root";      // your MySQL username
$dbpass = "";          // your MySQL password
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
        // Check if username already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$user]);
        if ($stmt->rowCount() > 0) {
            $error = "❌ Username already taken";
        } else {
            // Insert new user
            $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            if ($stmt->execute([$user, $hashedPass])) {
                $success = "✅ Account created! You can now login.";
            } else {
                $error = "❌ Failed to create account. Try again.";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Create Account</title>

<style>
* { box-sizing: border-box; }
body { margin:0; font-family: Arial, sans-serif; }

/* ===== Animations ===== */
@keyframes shake {
    0%,100% { transform: translateX(0); }
    20% { transform: translateX(-8px); }
    40% { transform: translateX(8px); }
    60% { transform: translateX(-6px); }
    80% { transform: translateX(6px); }
}

@keyframes fadeSlide {
    from { opacity: 0; transform: translateY(25px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Spotlight effect */
.spotlight {
    position: fixed; /* fixed to viewport */
    top: 0; 
    left: 0;
    width: 200px;
    height: 200px;
    pointer-events: none;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 80%);
    transform: translate(-50%, -50%);
    transition: top 0.05s, left 0.05s;
    mix-blend-mode: screen;
    z-index: 9999;
}

/* ===== Page Layout ===== */
.page {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #74ABE2, #5563DE);
}

/* vertical column wrapper for title + box */
.page-column {
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Page title above box */
.page-title {
    color: #fff;
    font-size: 36px;
    margin-bottom: 25px;
    text-shadow: 0 0 10px #00ff99;
    animation: fadeSlide 0.6s ease;
    text-align: center;
}

/* Box */
.box {
    background: rgba(0,0,0,0.55);
    padding: 35px;
    border-radius: 18px;
    width: 360px;
    text-align: center;
    color: #fff;
    animation: fadeSlide 0.6s ease;
}

.box.shake {
    animation: shake 0.4s;
}

input {
    width: 92%;
    padding: 11px;
    margin: 10px 0;
    border-radius: 8px;
    border: none;
    transition: 0.3s;
}

input:focus {
    outline: none;
    transform: scale(1.05);
    box-shadow: 0 0 12px #00ff99;
}

input[type="submit"] {
    margin-top: 12px;
    background: #00ff99;
    font-weight: bold;
    cursor: pointer;
}

input[type="submit"]:hover {
    background: #00cc77;
    transform: translateY(-3px);
    box-shadow: 0 0 15px #00ff99;
}

.msg-error {
    color: #ff8080;
    margin-top: 10px;
    font-weight: bold;
}

.msg-success {
    color: #8dffb3;
    margin-top: 10px;
    font-weight: bold;
}

a {
    color: #00ff99;
    text-decoration: none;
}

a:hover {
    text-shadow: 0 0 8px #00ff99;
}
</style>
</head>

<body>
<div class="spotlight"></div>

<div class="page">
    <div class="page-column">
        <!-- TITLE ABOVE BOX -->
        <h1 class="page-title">Klane Database</h1>

        <div class="box <?php if ($error) echo 'shake'; ?>">
            <h2>Create Account</h2>

            <form method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm" placeholder="Confirm Password" required>
                <input type="submit" value="Create Account">
            </form>

            <?php if ($error) echo "<div class='msg-error'>$error</div>"; ?>
            <?php if ($success) echo "<div class='msg-success'>$success</div>"; ?>

            <div style="margin-top:15px;">
                <a href="test1.php">← Back to Login</a>
            </div>
        </div>
    </div>
</div>

<script>
const spotlight = document.querySelector('.spotlight');
document.addEventListener('mousemove', e => {
    spotlight.style.left = `${e.clientX}px`;
    spotlight.style.top = `${e.clientY}px`;
});
</script>

</body>
</html>
