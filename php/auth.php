<?php 
session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {

    include "../db_conn.php";   # اتصال الداتا بيز
    include "func-validation.php"; # فحص الفورم

    $email    = $_POST['email'];
    $password = $_POST['password'];

    # ✅ 1. الحالة الخاصة: إيميل وباسورد ثابت
    if ($email === "moamrmousa333@gmail.com" && $password === "12345678") {
        $_SESSION['user_id']    = 999; // أي ID مميز
        $_SESSION['user_email'] = $email;
        $_SESSION['is_admin']   = true;

        header("Location: ../dashboard-project-main/index.php");
        exit;
    }

    # ✅ 2. التحقق من جدول admin
    $text = "Email";
    $location = "../login.php";
    $ms = "error";
    is_empty($email, $text, $location, $ms, "");

    $text = "Password";
    $location = "../login.php";
    $ms = "error";
    is_empty($password, $text, $location, $ms, "");

    # البحث عن الإيميل
    $sql = "SELECT * FROM admin WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);

    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch();

        $user_id       = $user['id'];
        $user_email    = $user['email'];
        $user_password = $user['password'];

        if ($email === $user_email && $password === $user_password) {
            $_SESSION['user_id']    = $user_id;
            $_SESSION['user_email'] = $user_email;

            header("Location: ../admin.php");
            exit;
        } else {
            $em = "Incorrect Email or Password";
            header("Location: ../login.php?error=$em");
            exit;
        }
    } else {
        $em = "Incorrect Email or Password";
        header("Location: ../login.php?error=$em");
        exit;
    }

} else {
    header("Location: ../login.php");
    exit;
}
