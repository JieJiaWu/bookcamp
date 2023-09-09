<?php
require_once "Sql_Login.php";
require_once "cdn.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 從 POST 請求中獲取資料

    $confirm = isset($_POST['confirm']) ? $_POST['confirm'] : false;
    $id = isset($_POST['id']) ? $_POST['id'] : "";
    $new_title = isset($_POST['new_title']) ? $_POST['new_title'] : "";
    $new_content = isset($_POST['new_content']) ? $_POST['new_content'] : "";
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : "";
    $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : "";
echo $id;
    if ($confirm) {
        // 執行資料庫更新操作
        $sql = "UPDATE post SET title = :title, content = :content, category_id = :category_id WHERE user_id = :user_id AND id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $new_title);
        $stmt->bindParam(':content', $new_content);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        // 回傳成功訊息給 AJAX 請求
        echo "success";
    } else {
        // 回傳錯誤訊息給 AJAX 請求
        echo "error";
    }
}
?>