<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">


<?php
require_once "Sql_Login.php";
require_once "cdn.php";
session_start();


$sqlpost = "SELECT * FROM category";
$stmtpost = $pdo->prepare($sqlpost);
$stmtpost->execute();
$resultpost = $stmtpost->fetchAll(PDO::FETCH_ASSOC);


//類別種類
$sqlcategory = "SELECT * FROM category";
$postcategory = $pdo->prepare($sqlcategory);
try {
    $postcategory->execute();
    $rowCategory = $postcategory->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo $e->getMessage();
}


$perPage = 10; // 每页显示的文章数量
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1; // 当前页数
$offset = ($currentPage - 1) * $perPage; // 计算偏移量
if (isset($_GET["orderId"])) {
    $orderId = $_GET["orderId"];
    switch ($orderId) {
        case "idDesc":
            $sql = "SELECT * FROM post p JOIN `category` c ON 
            c.category_id = p.category_id ORDER BY id DESC";
            break;
        case "idAsc":
            $sql = "SELECT * FROM post p JOIN `category` c ON 
            c.category_id = p.category_id ORDER BY id ASC";
            break;
    }
    $sql .= " LIMIT :perPage OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $sqlCount = "SELECT COUNT(*) AS total FROM `post`";
    $stmtCount = $pdo->prepare($sqlCount);
    $stmtCount->execute();
    $totalPosts = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($totalPosts / $perPage); // 使用 ceil() 函數向上取整



} elseif (isset($_GET["orderDate"])) {
    // 發文時間
    $orderDate = $_GET["orderDate"];
    switch ($orderDate) {
        case "dateAsc":
            $sql = "SELECT * FROM post p JOIN `category` c ON 
            c.category_id = p.category_id ORDER BY p.publish_time ASC";
            break;
        case "dateDesc":
            $sql = "SELECT * FROM post p JOIN `category` c ON 
            c.category_id = p.category_id ORDER BY p.publish_time DESC";
            break;
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


} elseif (isset($_GET["category"])) {
    // 類別搜尋
    $category = $_GET["category"];
    $sql = $sql = "SELECT * FROM `post` p
    JOIN `category` c ON c.category_id = p.category_id
    WHERE c.name = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$category]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

} else {
    try {
        $sql = "SELECT * FROM `post` p JOIN `category` c ON c.category_id = p.category_id LIMIT :perPage OFFSET :offset";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sqlCount = "SELECT COUNT(*) AS total FROM `post`";
        $stmtCount = $pdo->prepare($sqlCount);
        $stmtCount->execute();
        $totalPosts = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPages = ceil($totalPosts / $perPage); // 使用 ceil() 函數向上取整

        // 確保當前頁數不超過總頁數的範圍

    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}
?>
<style>

</style>

<body>
    <div class="container">
        <!-- 側邊欄位 -->
        <div class="sidebar">
            <h4 class="mb-4 text-dark ">
                <i class="fa-brands fa-gofore fs-3 mt-3  ps-4" style="color:red"></i>
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
        <!-- 文章列表內容 -->
        <div class="content">
            <div class="blog-table">
                <div class="blog-tr bg-light">
                    <div class="blog-th">
                        <div class="form-check me-2">
                            <input class="form-check-input" type="checkbox" value="" id="checkAll">
                        </div>
                        <span>批量<br />操作</span>
                    </div>
                    <div class="blog-th d-flex justify-content-center">刪除</div>
                    <div class="blog-th d-flex justify-content-center">編輯</div>
                    <div class="blog-th d-flex justify-content-center">編號
                        <?php if (!isset($orderId) or $orderId === "idAsc"): ?>
                            <a href="page_Select.php?orderId=idDesc" class="btn btn-outline-primary btn-sm ms-2"
                                role="button">
                                <i class="fas fa-sort-amount-up-alt fa-fw"></i>
                            </a>
                        <?php elseif ($orderId === "idDesc"): ?>
                            <a href="page_Select.php?orderId=idAsc" class="btn btn-outline-primary btn-sm ms-2"
                                role="button">
                                <i class="fas fa-sort-amount-down fa-fw"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="blog-th d-flex justify-content-center">標題</div>
                    <div class="blog-th d-flex justify-content-center">發佈者</div>
                    <div class="blog-th d-flex justify-content-center">發文時間
                        <?php if (!isset($orderDate) or ($orderDate === "dateAsc") or (isset($orderId))): ?>
                            <a href="page_Select.php?orderDate=dateDesc" class="btn btn-outline-primary btn-sm ms-2"
                                role="button">
                                <i class="fas fa-sort-amount-up-alt fa-fw"></i>
                            </a>
                        <?php elseif ($orderDate === "dateDesc"): ?>
                            <a href="page_Select.php?orderDate=dateAsc" class="btn btn-outline-primary btn-sm ms-2"
                                role="button">
                                <i class="fas fa-sort-amount-down fa-fw"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="blog-th d-flex justify-content-center">點閱數
                        <div class="dropdown">
                            <a class="btn btn-outline-primary dropdown-toggle ms-2 btn-sm" href="#" role="button"
                                id="blogAuthorDropdown" data-bs-toggle="dropdown" aria-expanded="false"></a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="blogAuthorDropdown">
                                <!-- <li>
                                    <a class="dropdown-item <?php if (!isset($author))
                                        echo "active"; ?>" aria-current="page" href="blog.php">全部</a>
                                </li> -->
                                <!-- <?php foreach ($rowCategory as $valueBlogAuthor): ?>
                                    <li>
                                        <a class="dropdown-item <?php if (isset($author) && $valueBlogAuthor["id"] == $author)
                                            echo "active" ?>" href="blog.php?author=<?= $valueBlogAuthor["id"] ?>"><?= $valueBlogAuthor["name"] ?></a>
                                    </li>
                                <?php endforeach; ?> -->
                            </ul>
                        </div>
                    </div>
                    <div class="blog-th d-flex justify-content-center">回覆數

                    </div>

                    <!--  -->
                    <div class="blog-th d-flex justify-content-center">類別
                        <div class="dropdown">
                            <a class="btn btn-outline-primary dropdown-toggle ms-2 btn-sm" href="#" role="button"
                                id="blogCategoryDropdown" data-bs-toggle="dropdown" aria-expanded="false"></a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="blogCategoryDropdown">
                                <li>
                                    <a class="dropdown-item <?php if (!isset($category))
                                        echo "active"; ?>" aria-current="page" href="page_Select.php">全部</a>

                                </li>
                                <?php foreach ($resultpost as $valueBlogCategory): ?>
                                    <li>
                                        <a class="dropdown-item <?php if (isset($category) && $valueBlogCategory["name"] == $category)
                                            echo "active" ?>"
                                            href="page_Select.php?category=<?= $valueBlogCategory["name"] ?>"><?= $valueBlogCategory["name"] ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="orderDetail">
                    <?php foreach ($results as $value): ?>
                        <div class="blog-tr">
                            <div class="blog-td">
                                <!-- CHECKBOX -->
                                <input class="form-check-input order-check" type="checkbox" value="<?= $value["id"] ?>"
                                    name="batch_id[]" form="blogBatchForm">
                            </div>
                            <!-- DELETE -->
                            <div class="blog-td">
                                <a href="page_delete.php?id=<?= $value["id"] ?>" role="button"
                                    class="btn btn-outline-primary btn-sm"><i
                                        class="fas fa-trash-alt fa-fw d-flex justify-content-center"></i></a>
                            </div>
                            <div class="blog-td">
                                <a href="page_edit.php?id=<?= $value["id"] ?>" role="button"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-edit fa-fw d-flex justify-content-center"></i></a>
                            </div>
                            <div class="blog-td d-flex justify-content-center">
                                <!-- 編號 -->
                                <?= $value["id"] ?>
                            </div>
                            <div class="blog-td  d-flex justify-content-center">
                                <!-- 標題 -->
                                <?php $title = $value["title"];
                                $maxChars = 10; // 設定標題的最大字數
                            
                                if (mb_strlen($title) > $maxChars) {
                                    $title = mb_substr($title, 0, $maxChars) . '...';
                                }
                                echo $title;
                                ;
                                ?>

                            </div>
                            <div class="blog-td  d-flex justify-content-center">
                                <!-- 使用者ID -->
                                <?= $value['user_id'] ?>
                            </div>
                            <div class="blog-td  d-flex justify-content-center">
                                <!-- 發文時間 -->
                                <?= date('Y年m月d', strtotime($value['publish_time'])); ?>
                            </div>
                            <div class="blog-td  d-flex justify-content-center">
                                <!-- 點閱 -->
                                <?= $value["views"] ?>
                            </div>
                            <div class="blog-td  d-flex justify-content-center">
                                <!-- 觀看 -->
                                <?= $value['replies'] ?>
                            </div>
                            <div class="blog-td  d-flex justify-content-center">
                                <!-- 類別 -->
                                <?= $value['name'] ?>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- 分頁部分 -->
            <div class="pagination">
                <?php if (isset($totalPages) && isset($orderId) && $orderId == "idDesc"): ?>
                    <?php if ($currentPage > 1): ?>
                        <a href="page_Select.php?orderId=idDesc&page=<?= $currentPage - 1 ?>" class="page-link">&laquo;
                            Previous</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="page_Select.php?orderId=idDesc&page=<?= $i ?>"
                            class="page-link <?= ($i == $currentPage) ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <a href="page_Select.php?orderId=idDesc&page=<?= $currentPage + 1 ?>" class="page-link">Next &raquo;</a>
                    <?php endif; ?>


                <?php elseif (isset($totalPages) && isset($orderId) && $orderId == "idAsc"): ?>
                    <?php if ($currentPage > 1): ?>
                        <a href="page_Select.php?orderId=idAsc&page=<?= $currentPage - 1 ?>" class="page-link">&laquo;
                            Previous</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="page_Select.php?orderId=idAsc&page=<?= $i ?>"
                            class="page-link <?= ($i == $currentPage) ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <a href="page_Select.php?orderId=idAsc&page=<?= $currentPage + 1 ?>" class="page-link">Next &raquo;</a>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if ($currentPage > 1): ?>
                        <a href="page_Select.php?page=<?= $currentPage - 1 ?>" class="page-link">&laquo; Previous</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="page_Select.php?page=<?= $i ?>" class="page-link <?= ($i == $currentPage) ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <a href="page_Select.php?page=<?= $currentPage + 1 ?>" class="page-link">Next &raquo;</a>
                    <?php endif; ?>
                <?php endif; ?>

                <button type="button" class="btn btn-parimay" id="btn">刪除</button>

            </div>


        </div>
    </div>
    </div>

    </div>

    <script>

        $(function () {
            $('#checkAll').on('change', function () {
                let checkall = $(this).is(':checked');
                let input = $('#orderDetail').find('input');
                if (checkall) {
                    input.prop('checked', true);
                } else {
                    input.prop('checked', false);
                }
            })
            $('#btn').on('click', function () {
                let input = $('#orderDetail').find('input[type="checkbox"]:checked');
                let checkedValues = input.map(function () {
                    return this.value;
                }).get();
                console.log(checkedValues);
                $.ajax({
                    url: 'page_delete.php',                        // url位置
                    type: 'post',                   // post/get
                    data: { querytag: checkedValues },       // 輸入的資料
                }).then(location.reload());
            })

        })
    </script>
</body>