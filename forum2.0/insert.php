<?php
require_once 'Sql_Login.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $id = $_POST["id"];
    $category = $_POST["category"];

    $stmt = $pdo->prepare("INSERT INTO post (title,content,user_id,category_id) 
    VALUES (:title,:content,:user_id,:category_id)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':user_id', $id);
    $stmt->bindParam(':category_id', $category);
    if ($stmt->execute()) {
        ?>
        <script>
            alert("新增會員資料成功");
            window.location.href = "login.php";
        </script>
        <?php
    } else {
        echo "新增失敗";
    }
}
?>