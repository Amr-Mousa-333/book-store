<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login | Book Store</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* نفس التصميم اللي انت كاتبه */
body {
    background: linear-gradient(135deg, #f9f7f1 0%, #e9dcc9 100%);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}
.login-container {
    background: rgba(255,255,255,0.95);
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.2);
    width: 100%;
    max-width: 400px;
}
.login-container h1 {
    text-align: center;
    margin-bottom: 30px;
    font-weight: 700;
    color: #8b4513;
}
.btn-brown {
    background: linear-gradient(135deg, #8b4513, #a0522d);
    color: #fff;
    border: none;
    font-weight: 600;
    width: 100%;
}
.btn-brown:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(139,69,19,0.4);
}
.text-center a { text-decoration: none; color: #a0522d; font-weight: 500; }
.text-center a:hover { text-decoration: underline; }
.toggle-password {
    position: absolute; top: 50%; right: 15px;
    transform: translateY(-50%); cursor: pointer; color: #555;
}
.position-relative { position: relative; }
</style>
</head>
<body>

<div class="login-container">
    <h1>Admin Login</h1>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger text-center">
            <?= htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="php/auth.php">
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="you@example.com" required>
        </div>

        <div class="mb-3 position-relative">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="••••••••" required>
            <i class="fas fa-eye toggle-password" id="togglePassword"></i>
        </div>

        <button type="submit" class="btn btn-brown mb-3">Login</button>

        <div class="text-center mb-2">
            <a href="signup.php">Create a new account</a>
        </div>
        <div class="text-center">
            <a href="index.php">Back to Store</a>
        </div>
    </form>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
document.getElementById("togglePassword").addEventListener("click", function() {
    const password = document.getElementById("password");
    const type = password.type === "password" ? "text" : "password";
    password.type = type;
    this.classList.toggle("fa-eye-slash");
});
</script>

</body>
</html>
