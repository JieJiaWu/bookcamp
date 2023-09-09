<?php
require_once "Sql_Login.php";
// 建立資料庫連線

// 接收從表單頁面傳遞過來的帳號和密碼
$username = $_POST['username'];
$password = $_POST['password'];


// 使用預備陳述式準備 SQL 查詢
$stmt = $pdo->prepare("SELECT * FROM Client WHERE username = :username");
// 預備陳述式中的參數占位符 <---,>-- 要綁定的變數 左邊的值替換右邊的值
$stmt->bindParam(':username', $username);

// 執行查詢
// 將會執行預備陳述式並返回一個 PDOStatement 物件。
// 在執行期間，PDO 將會將輸入參數值綁定到 SQL 陳述式中的對應位置。
$stmt->execute();

// 檢查是否找到匹配的使用者紀錄
if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // 驗證密碼是否相符
    if (password_verify($password, $row['password'])) {
        session_start();
        $_SESSION['username'] = $row['username'];
        $_SESSION['id'] = $row['client_id'];

        // 重定向到其他頁面或顯示成功訊息
        header("Location: login.php"); // 修改為您的歡迎頁面的 URL
        exit();
    } else {
        // 密碼驗證失敗
?>
        <script>
            alert("密碼不正確");
            window.location.href = ("login.php");
        </script>
    <?php
    }
} else {
    // 找不到匹配的使用者紀錄
    ?>
    <script>
        alert("找不到帳號");
        window.location.href = ("login.php");
    </script>
<?php

}
?>