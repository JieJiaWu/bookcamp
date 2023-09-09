<?php
require_once "Sql_Login.php";
require_once "cdn.php";
session_start();

// 檢查用戶是否已登入，否則導向登入頁面
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// 檢查是否有傳遞資料ID
if (!isset($_GET['id'])) {
    echo "缺少資料ID";
    exit;
}

// 獲取要編輯的資料ID
$id = $_GET['id'];

// 檢查表單是否已提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 從POST請求中獲取修改後的值
    $newUsername = $_POST['new_username'];
    $newEmail = $_POST['new_email'];
    $newPassword = $_POST['new_password'];
    $newBio = $_POST['new_bio'];

    // 更新資料庫中的資料
    $sql = "UPDATE client SET username = :username, email = :email, password = :password, bio = :bio WHERE client_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $newUsername);
    $stmt->bindParam(':email', $newEmail);
    $stmt->bindParam(':password', $newPassword);
    $stmt->bindParam(':bio', $newBio);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "資料更新成功";
    } else {
        echo "更新失敗";
    }

    session_unset();
    header("Location: login.php");
    exit;
}

// SQL撈編輯的資料
$sql = "SELECT * FROM client WHERE client_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// 檢查是否有編輯的資料
if (!$result) {
    echo "找不到該資料";
    exit;
}

// 提取編輯前的值
$currentUsername = $result['username'];
$currentEmail = $result['email'];
$currentPassword = $result['password'];
$currentBio = $result['bio'];
?>

<!-- 編輯表單 -->
<div class="container">
    <h2 class="mt-5 text-primary">編輯資料</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="new_username" class="form-label">新名稱：</label>
            <input type="text" name="new_username" class="form-control" value="<?php echo $currentUsername; ?>">
        </div>
        <div class="mb-3">
            <label for="new_email" class="form-label">新電子郵件：</label>
            <input type="email" name="new_email" class="form-control" value="<?php echo $currentEmail; ?>">
        </div>
        <div class="mb-3">
            <label for="new_password" class="form-label">新密碼：</label>
            <input type="password" name="new_password" class="form-control" value="<?php echo $currentPassword; ?>">
        </div>
        <div class="mb-3">
            <label for="new_bio" class="form-label">個人介紹：</label>
            <textarea name="new_bio" class="form-control"><?php echo $currentBio; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">保存</button>
    </form>
</div>
