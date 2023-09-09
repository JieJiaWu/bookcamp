<?php
require_once "Sql_Login.php";
// 接收從表單頁面傳遞過來的帳號和密碼
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$bio = $_POST['bio'];

// 對密碼進行哈希處理
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("SELECT * FROM client WHERE username = :username");
$stmt->bindParam(':username', $username);
$stmt->execute();
// 判斷帳號是否已存在
if ($stmt->rowCount() > 0) {
    $alert = "帳號已存在";
    echo "<script type='text/javascript'>alert('$alert'); window.location.href='register.php';</script>";
} else {
    try {
        $stmt = $pdo->prepare("INSERT INTO Client (username, password,email,bio) VALUES (:username, :password,:email,:bio)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':bio', $bio);
        $stmt->execute();
        $alert = "新增成功！將跳轉至登入頁面";
        echo "<script 
        type='text/javascript'>alert('$alert');
        window.location.href='login.php';
        </script>";
        // header("location:login.php");
    } catch (Exception $e) {
        die("Error" . $e->getMessage() . "<br>");
    };
}
// 將使用者名稱和哈希後的密碼插入資料庫
