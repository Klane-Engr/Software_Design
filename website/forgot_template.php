<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password</title>

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

/* ===== Spotlight ===== */
.spotlight {
    position: fixed;
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

/* ===== Layout ===== */
.page {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #74ABE2, #5563DE);
}

.page-column {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.page-title {
    color: #fff;
    font-size: 36px;
    margin-bottom: 25px;
    text-shadow: 0 0 10px #00ff99;
    animation: fadeSlide 0.6s ease;
    text-align: center;
}

/* ===== Box ===== */
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

/* ===== Inputs ===== */
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

/* ===== Messages ===== */
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

/* ===== Links ===== */
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
        <h1 class="page-title">Reset Password</h1>

        <div class="box <?php if ($error) echo 'shake'; ?>">
            <h2>Forgot Password</h2>

            <form method="post" action="forgot.php">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="New Password" required>
                <input type="password" name="confirm" placeholder="Confirm Password" required>
                <input type="submit" value="Reset Password">
            </form>

            <?php if ($error): ?>
                <div class="msg-error"><?= $error ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="msg-success"><?= $success ?></div>
            <?php endif; ?>

            <div style="margin-top:15px;">
                <a href="test1.php">← Back to Login</a>
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

</body>
</html>
