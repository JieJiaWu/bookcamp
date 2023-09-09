<?php
require "./Sql_order.php";
require "cdn.php";

/* 這裡是訂單 */

// 抓到mySQL-bookorder
$order = "SELECT * FROM `bookorder`";
$sqlOrder = $pdo->prepare($order); //準備
try {
    $sqlOrder->execute(); //執行
    $roworder = $sqlOrder->fetchAll(); //取得結果
} catch (PDOException $e) { //例外
    die("Error!: " . $e->getMessage() . "<br/>"); //例外執行
}
;

// 抓到mySQL-product
$product = "SELECT * FROM `product`";
$sqlproduct = $pdo->prepare($product); //準備
try {
    $sqlproduct->execute(); //執行
    $rowproduct = $sqlproduct->fetchAll(); //取得結果
} catch (PDOException $e) { //例外
    die("Error!: " . $e->getMessage() . "<br/>"); //例外執行
}
;


// 抓到mySQL-client
$client = "SELECT * FROM `client`";
$sqlClient = $pdo->prepare($client);
try {
    $sqlClient->execute();
    $rowClient = $sqlClient->fetchAll();
} catch (PDOException $e) {
    die("Error!: " . $e->getMessage() . "<br/>");
}
;


// 抓到mySQL-order_status
$orderStatus = "SELECT * FROM `order_status`";
$sqlorderStatus = $pdo->prepare($orderStatus);
try {
    $sqlorderStatus->execute();
    $roworderStatus = $sqlorderStatus->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error!: " . $e->getMessage() . "<br/>");
}
;


// 抓到mySQL-coupon
$coupon = "SELECT * FROM `coupon`";
$sqlCoupon = $pdo->prepare($coupon);
try {
    $sqlCoupon->execute();
    $rowCoupon = $sqlCoupon->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error!: " . $e->getMessage() . "<br/>");
}
;


// 抓到mySQL-delivery
$delivery = "SELECT * FROM `delivery`";
$sqlDelivery = $pdo->prepare($delivery);
try {
    $sqlDelivery->execute();
    $rowDelivery = $sqlDelivery->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error!: " . $e->getMessage() . "<br/>");
}
;


// 抓到mySQL-receipt
$receipt = "SELECT * FROM `receipt`";
$sqlReceipt = $pdo->prepare($receipt);
try {
    $sqlReceipt->execute();
    $rowReceipt = $sqlReceipt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error!: " . $e->getMessage() . "<br/>");
}
;


// 抓到mySQL-pay
$pay = "SELECT * FROM `pay`";
$sqlPay = $pdo->prepare($pay);
try {
    $sqlPay->execute();
    $rowPay = $sqlPay->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error!: " . $e->getMessage() . "<br/>");
}
;


/* 這裡是訂單明細 */

// 抓到mySQL-bookorder_detail
// order_id,product_id,product_count,product_price,delivery_fee
$orderdetail = "SELECT * FROM `bookorder_detail`";
$sqlOrderdetail = $pdo->prepare($orderdetail); //準備
$sqlOrderdetail->execute(
    // $_POST['order_id'],
    // $_POST['product_id'],
    // $_POST['product_count'],
    // $_POST['product_price'],
    // $_POST['delivery_fee'],
); //執行
$roworderdetail = $sqlOrderdetail->fetchAll(); //取得結果


;







?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>訂單資料管理</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>訂單編號</th>
                <th>會員編號</th>
                <th>消費金額</th>
                <th>付款方式</th>
                <th>發票方式</th>
                <th>配送方式</th>
                <th>收貨人名稱</th>
                <th>收貨人電話</th>
                <th>收貨人地址</th>
                <th>優惠卷折扣</th>
                <th>訂單狀態</th>
                <th>訂單日期</th>
                <th colspan="3">管理</th>
                <th></th>
                <th></th>

            </tr>
        </thead>
        <tbody>
            <div class="accordion" id="order_Detail">
                <?php
                // 訂單顯示資料
                foreach ($roworder as $key => $value) {
                    ?>
                    <tr>
                        <td>
                            <?= $value["order_id"]; ?>
                        </td>
                        <td>
                            <?= $value["client_id"]; ?>
                        </td>
                        <td>
                            <?= $value["total"]; ?>
                        </td>
                        <td>
                            <?= $rowPay[$value["pay_id"]]["pay_status"]; ?>
                        </td>
                        <td>
                            <?= $rowReceipt[$value["receipt_id"]]["receipt_status"]; ?>
                        </td>
                        <td>
                            <?= $rowDelivery[$value["delivery_id"]]["delivery_status"]; ?>
                        </td>
                        <td>
                            <?= $value["consignee"]; ?>
                        </td>
                        <td>
                            <?= $value["consignee_phone"]; ?>
                        </td>
                        <td>
                            <?= substr($value["consignee_address"], 0, 9); ?>
                        </td>
                        <td>
                            <?= $rowCoupon[$value["coupon_id"]]["coupon_name"]; ?>
                        </td>
                        <td>
                            <?= $roworderStatus[$value["order_status_id"]]["order_d_status"]; ?>
                        </td>
                        <td>
                            <?= $value["order_date"]; ?>
                        </td>
                        <td>
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse<?= $key ?>" aria-controls="collapse<?= $key ?>">
                                明細
                            </button>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <!-- 訂單顯示資料範圍 -->
                        <td colspan="11">
                            <div id="collapse<?= $key ?>" class="accordion-collapse collapse"
                                data-bs-parent="#order_Detail">
                                <div class="accordion-body">
                                    <!-- 訂單明細 -->
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>order_id</th>
                                                <th>product_id</th>
                                                <th>delivery_fee</th>
                                                <th>product_count</th>
                                                <th>product_price</th>
                                                <th>orderdetail_id</th>
                                                <th>編輯</th>
                                                <th>刪除</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            // 訂單明細顯示資料
                                        
                                            foreach ($roworderdetail as $detail) {
                                                if ($detail["order_id"] == $value["order_id"]) {
                                                    ?>
                                                    <div>

                                                        <tr>
                                                            <td>
                                                                <?= $detail["order_id"]; ?>
                                                            </td>
                                                            <td>
                                                                <?= $detail["product_id"]; ?>
                                                            </td>
                                                            <td>
                                                                <?= $detail["delivery_fee"]; ?>
                                                            </td>
                                                            <td>
                                                                <?= $detail["product_count"]; ?>
                                                            </td>
                                                            <td>
                                                                <?= $detail["product_price"]; ?>
                                                            </td>
                                                            <td>
                                                                <?= $detail["orderdetail_id"]; ?>
                                                            </td>
                                                            <td><button>編輯</button></td>
                                                            <td><button>刪除</button></td>
                                                        </tr>

                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php }
                ?>
            </div>
        </tbody>
    </table>





</body>

</html>