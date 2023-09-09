<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

<?php
require_once "cdn.php";

?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <style>
        @font-face {
            font-family: 'CustomFont';
            src: url('../ttf/Cubic_11_1.010_R.ttf') format('truetype');
        }

        h4 {
            font-family: 'CustomFont',;
        }
    </style>
</head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <div class="sidebar">
            <h4 class="mb-4 text-dark">
                <i class="fa-brands fa-gofore fs-3 mt-3 ps-4" style="color:red"></i>
                FORUM MANAGE
            </h4>
            <ul class="nav flex-column">
                <li class="nav-item ">
                    <a class="nav-link" href="login.php ">
                        Front Page
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="Sql_Select.php">
                        Member
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="page_insert.php">
                        New Page
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="page_Select.php">
                        PManage

                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php?logout=true">
                        Logout
                    </a>
                </li>
                <li class="nav-item">
                    <a class="">
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
            <?php if (isset($_SESSION['username'], $_SESSION['id'])) { ?>
            <?php } else { ?>
                <form method="POST" action="login_process.php" class="mt-3">
                    <h2 class="mt-2">登入</h2>
                    <div class="form-group">
                        <input class="form-control mt-2" type="text" name="username" placeholder="使用者名稱" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control mt-2" type="password" name="password" placeholder="密碼" required>
                    </div>
                    <input class="btn btn-primary mt-2" type="submit" value="登入">
                    <a class="btn btn-primary mt-2" href="register.php">註冊</a>
                </form>
            <?php } ?>
        </div>
    </div>
</body>

</html>