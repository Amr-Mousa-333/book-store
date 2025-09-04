<?php
session_start();
include "db_conn.php"; // الاتصال بقاعدة البيانات PDO

$message = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password)) {
        $message = "<div class='alert alert-danger text-center'>❌ Please fill all fields</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='alert alert-danger text-center'>❌ Invalid email address</div>";
    } elseif ($password !== $confirm_password) {
        $message = "<div class='alert alert-danger text-center'>❌ Passwords do not match</div>";
    } else {
        // تحقق من وجود البريد مسبقًا
        $stmt = $conn->prepare("SELECT id FROM admin WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $message = "<div class='alert alert-danger text-center'>❌ Email already exists</div>";
        } else {
            // إضافة المسؤول الجديد
            $hashed_password = $password;
            $stmt = $conn->prepare("INSERT INTO admin (full_name, email, password) VALUES (:full_name, :email, :password)");
            $stmt->bindParam(':full_name', $full_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            if ($stmt->execute()) {
                $message = "<div class='alert alert-success text-center'>✅ Account created successfully. <a href='login.php'>Login here</a></div>";
            } else {
                $message = "<div class='alert alert-danger text-center'>❌ Something went wrong</div>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up | Book Store</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
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
    max-width: 450px;
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
.text-center a {
    text-decoration: none;
    color: #a0522d;
    font-weight: 500;
}
.text-center a:hover {
    text-decoration: underline;
}
.toggle-password {
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    cursor: pointer;
    color: #555;
}
.position-relative { position: relative; }
</style>
</head>
<body>
<div class="login-container">
    <h1 class="text-center mb-4">Create Admin Account</h1>

    <?php if (!empty($message)) echo $message; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" name="full_name" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3 position-relative">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" required>
            <i class="fas fa-eye toggle-password" id="togglePassword"></i>
        </div>
        <div class="mb-3 position-relative">
            <label class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-brown mb-3">Sign Up</button>
        <div class="text-center">
            <a href="login.php">Already have an account? Login</a>
        </div>
        <div class="text-center mt-2">
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
