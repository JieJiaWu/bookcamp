<?php
require_once "Sql_Login.php";
require_once "cdn.php";
session_start();

try {
    $sql = "SELECT * FROM `post`";
    $stmt = $pdo->query($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $ex) {
    echo "Error: " . $ex->getMessage();
}
?>

<div class="container">
    <div class="sidebar">
        <h4 class="mb-4 text-dark">
            <i class="fa-brands fa-gofore"></i> 購物車管理後台
        </h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="login.php">
                    <i class="fa-regular fa-heart me-2"></i>首頁
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="Sql_Select.php">
                    <i class="fa-regular fa-heart me-2"></i>會員管理
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="page_insert.php">
                    <i class="fa-regular fa-heart me-2"></i>新增貼文
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="page_Select.php">
                    <i class="fa-regular fa-heart me-2"></i>貼文管理
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php?logout=true">
                    <i class="fa-regular fa-heart me-2"></i>登出系統
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link">
                    <?php
                    if (isset($_SESSION['username'], $_SESSION['id'])) {
                        $username = $_SESSION['username'];
                        $id = $_SESSION['id'];
                        ?><a class="animated-text ms-3">
                        <?php echo "歡迎：" . $username . "#" . $id . "<br>"; ?>
                    </a>
                    <?php } else {
                        echo "未登入";
                    }
                    ?>
                </a>
            </li>
        </ul>
    </div>
    <div class="content">

        <?php
        if (isset($_SESSION['username']) && $_SESSION['username'] === 'root') {
            foreach ($results as $row): ?>
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">ID:
                            <?php echo $row['id']; ?>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">Title:
                            <?php echo $row['title']; ?>
                        </h6>
                        <p class="card-text">Content:
                            <?php echo $row['content']; ?>
                        </p>
                        <p class="card-text text-muted">Date:
                            <?php echo $row['publish_time']; ?>
                        </p>
                        <p class="card-text text-muted">user_id:
                            <?php echo $row['user_id']; ?>
                        </p>
                        <a href="page_edit.php?user_id=<?php echo $row['user_id']; ?>" class="btn btn-warning">編輯</a>
                        <a href="page_delete.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">刪除</a>
                    </div>
                </div>

            <?php endforeach;
        } else if (isset($_SESSION['username'])) {
            ?>
                <script>
                    alert("你的權限不足");

                    window.location.href = "login.php";
                </script>
                <?php
        } else {
            ?>
                <script>
                    alert("請登入");
                    window.location.href = "login.php";
                </script>
                <?php

        } ?>
    </div>
</div>