<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">


<?php
require_once "Sql_Login.php";
require_once "cdn.php";
session_start();

try {
    $sql = "SELECT * FROM client";
    $stmt = $pdo->query($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<div class="container">
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
        foreach ($results as $row) : ?>
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">ID:
                        <?php echo $row['client_id']; ?>
                    </h5>
                    <p class="card-text">Username:
                        <?php echo $row['username']; ?>
                    </p>
                    <p class="card-text">Email:
                        <?php echo $row['email']; ?>
                    </p>
                    <p class="card-text">Password:
                        <?php echo $row['password']; ?>
                    </p>
                    <p class="card-text">Bio:
                        <?php echo $row['bio']; ?>
                    </p>
                    <a href="edit.php?id=<?php echo $row["client_id"] ?>" class="btn btn-warning">編輯
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>