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

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$user]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($row && password_verify($pass, $row['password'])) {
		$_SESSION['loggedin'] = true;
		$_SESSION['user'] = $row['username'];
		$loginSuccess = true; // trigger animation
	}
	 else {
        $errorMessage = "❌ Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>

<style>
* { box-sizing: border-box; }
body { margin:0; font-family: Arial, sans-serif; }

/* Animations */
@keyframes shake {
    0%,100% { transform: translateX(0); }
    20% { transform: translateX(-8px); }
    40% { transform: translateX(8px); }
    60% { transform: translateX(-6px); }
    80% { transform: translateX(6px); }
}

@keyframes fadeSlide {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Spotlight */
.spotlight {
    position: fixed;
    width: 200px;
    height: 200px;
    pointer-events: none;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 80%);
    transform: translate(-50%, -50%);
    mix-blend-mode: screen;
}

.fade-out {
    animation: fadeOut 0.6s ease forwards;
}

@keyframes fadeOut {
    from {
        opacity: 1;
        transform: scale(1);
    }
    to {
        opacity: 0;
        transform: scale(0.96);
    }
}

/* Glowing links */
.glow-link {
    color: #00ff99;
    text-decoration: none;
    display: inline-block;
    transition: 
        color 0.3s ease,
        text-shadow 0.3s ease,
        transform 0.3s ease;
}

.glow-link:hover {
    color: #b9ffe0;
    text-shadow:
        0 0 6px #00ff99,
        0 0 12px #00ff99,
        0 0 20px rgba(0,255,153,0.6);
    transform: translateY(-2px);
}



/* Login page */
.login-page {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #74ABE2, #5563DE);
}

.login-column {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.page-title {
    color: #fff;
    font-size: 36px;
    margin-bottom: 25px;
    text-shadow: 0 0 10px #00ff99;
}

.login-box {
    background: rgba(0,0,0,0.55);
    padding: 30px;
    border-radius: 15px;
    width: 300px;
    text-align: center;
    color: #fff;
}

.login-box.shake {
    animation: shake 0.4s;
}

input {
    width: 90%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 8px;
    border: none;
}

input:focus {
    outline: none;
    transform: scale(1.05);
    box-shadow: 0 0 12px #00ff99;
}

input[type="submit"] {
    background: #00ff99;
    font-weight: bold;
    cursor: pointer;
}

.error-message {
    color: #ff8080;
    margin-top: 10px;
}
</style>
</head>

<body>
<div class="spotlight"></div>

<div class="login-page" id="loginPage">
    <div class="login-column">
        <h1 class="page-title">Klane Database</h1>

        <div class="login-box <?php if ($errorMessage) echo 'shake'; ?>">
            <h2>Login</h2>

            <form method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" value="Login">
            </form>

            <?php if ($errorMessage) echo "<div class='error-message'>$errorMessage</div>"; ?>

            <div style="margin-top:15px;">
				<a href="test_create.php" class="glow-link">Create Account</a>
            </div>
            <div style="margin-top:10px;">
				<a href="forgot.php" class="glow-link">Forgot Password?</a>
            </div>
        </div>
    </div>
</div>
<script>
const spotlight = document.querySelector('.spotlight');
document.addEventListener('mousemove', e => {
    spotlight.style.left = e.clientX + 'px';
    spotlight.style.top = e.clientY + 'px';
});
</script>
<?php if (!empty($loginSuccess)): ?>
<script>
    const page = document.getElementById('loginPage');
    page.classList.add('fade-out');

    setTimeout(() => {
        window.location.href = "dashboard.php";
    }, 600); // must match animation time
</script>
<?php endif; ?>


</body>
</html>
