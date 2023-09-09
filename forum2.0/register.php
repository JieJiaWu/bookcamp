<?php
require_once "cdn.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>註冊</title>
</head>

<body>
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
                        session_start();
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
            <h2 class="mt-5">註冊新使用者</h2>
            <form action="register_insert.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">帳號:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">密碼:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">電子郵件:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="bio" class="form-label">個人介紹:</label>
                    <input type="text" class="form-control" id="bio" name="bio">
                </div>
                <button type="submit" class="btn btn-primary">註冊</button>
                <a class="btn btn-primary " href="login.php">返回</a>
            </form>
        </div>
    </div>
</body>

</html>