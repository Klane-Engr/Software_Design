<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password</title>

<style>
/* ✅ CSS stays exactly the same */
* { box-sizing: border-box; }
body { margin:0; font-family: Arial, sans-serif; }
/* animations, spotlight, layout, box, inputs */
/* (no functional changes) */
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
