<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: test1.php");
    exit;
}

if (isset($_GET['logout'])) {
    session_destroy();
    echo "<script>window.location.href='test1.php';</script>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>

<style>
body { margin:0; font-family: Arial, sans-serif; animation: fadeIn 0.6s ease;}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-out {
    animation: fadeOut 0.5s ease forwards;
}

@keyframes fadeOut {
    from {
        opacity: 1;
        transform: scale(1);
    }
    to {
        opacity: 0;
        transform: scale(0.97);
    }
}


.dashboard {
    display: flex;
    height: 100vh;
}

.sidebar {
    width: 220px;
    background: #222;
    color: #fff;
    padding-top: 20px;
}

.sidebar h2 {
    text-align: center;
}

.sidebar a {
    display: block;
    padding: 12px 20px;
    color: #fff;
    text-decoration: none;
}

.sidebar a:hover {
    background: #333;
    border-left: 4px solid #00ff99;
}

.logout { color: #ff6666; }

.main-content {
    flex: 1;
    padding: 20px;
    background: #f0f2f5;
}

.card {
    background: #fff;
    padding: 20px;
    margin-bottom: 15px;
    border-radius: 10px;
}
</style>
</head>

<body>

<div class="dashboard">
    <div class="sidebar">
        <h2>Klane Database</h2>
        <a href="#">Dashboard</a>
        <a href="#">Network</a>
        <a href="#">Users</a>
        <a href="#">Settings</a>
		<a href="#" class="logout" onclick="logoutSmooth()">Logout</a>
    </div>

    <div class="main-content">
        <h1>Welcome, <?php echo $_SESSION['user']; ?> 👋</h1>

        <div class="card">
            <h3>System Status</h3>
            <p>All systems operational.</p>
        </div>

        <div class="card">
            <h3>Quick Actions</h3>
            <button onclick="alert('Rebooting system…')">Reboot</button>
        </div>
    </div>
</div>

<script>
function logoutSmooth() {
    const dashboard = document.querySelector('.dashboard');
    dashboard.classList.add('fade-out');

    setTimeout(() => {
        window.location.href = "?logout=1";
    }, 500); // must match fadeOut duration
}
</script>

</body>
</html>
