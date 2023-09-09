<?php
require_once "Sql_order.php";
$client_id = rand(1, 20); //使用者的數量
$consignee = getchar(3); //收件人名子亂數
$consignee_address = [
    //地址的數量
    '436 臺中市清水區民有路25號',
    '414 臺中市烏日區三榮五路3號',
    '407 臺中市西屯區國安二路9號',
    '401 臺中市東區十甲東二街9號',
    '231 新北市新店區自強路28號',
    '221 新北市汐止區小坑路25號',
    '242 新北市新莊區壽山路26號',
    '224 新北市瑞芳區楓子瀨路22號',
    '722 臺南市佳里區祥和五街10號',
    '726 臺南市學甲區宅子港31號',
    '946 屏東縣恆春鎮梹榔路9號',
    '940 屏東縣枋寮鄉新開六路15號',
    '931 屏東縣佳冬鄉官埔31號',
    '324 桃園市平鎮區新貴北街13號',
    '320 桃園市中壢區月眉二路26號',
    '847 高雄市甲仙區中園路19號',
    '812 高雄市小港區永順街7號'
];
$consignee_phone = generateRandomPhoneNumber(); //電話隨機產生
$order_date = getdate(); //訂單時間
$order_status_id = rand(1, 3); //訂單狀態
$coupon_id = '1'; //優惠卷
$delivery_id = rand(1, 3); //配送方式
$receipt_id = rand(1, 3); //發票
$pay_id = rand(1, 4); //付款方式

// order_id	consignee	consignee_phone	consignee_address	order_date	order_status_id	client_id	coupon_id	delivery_id	receipt_id	pay_id	total	deli
$sql = "INSERT INTO `bookorder`(`order_id`, `consignee`, `consignee_phone`, `consignee_address`, `order_date`, `order_status_id`, `client_id`, `coupon_id`,
 `delivery_id`, `receipt_id`, `pay_id`, `total`, `delivery_fee`) VALUES 
 (?,?,?,?,?,?,?,?,?,?,?,?,?)";
$count = 0;
$order_id = $count;
$product_id = rand(1, 16);
$product_count = rand(1, 10);
$product_price = 1;
$orderdetail_id = $count;
$FalseDate = $pdo->prepare($sql);
try {
    $FalseDate->execute();
} catch (Exception $e) {
    echo $e->getMessage();
}


$sql2 = "INSERT INTO `bookorder_detail`(`order_id`, `product_id`, `product_count`, `product_price`, `orderdetail_id`, `client_id`) 
 VALUES (?,?,?,?,?,?)";
$FalseDate2 = $pdo->prepare($sql2);
try {
    $FalseDate2->execute();
} catch (Exception $e) {
    echo $e->getMessage();
}







function getchar($num) //隨機名稱
{
    $b = '';
    for ($i = 0; $i < $num; $i++) {
        $a = chr(mt_rand(0xB0, 0xD0)) . chr(mt_rand(0xA1, 0xF0));
        $b .= iconv('GB2312', 'UTF-8', $a);
    }
    return $b;
}
function generateRandomPhoneNumber() //隨機電話
{
    $prefix = '09';
    $length = 8; // 長度

    $randomNumber = '';
    for ($i = 0; $i < $length; $i++) {
        $randomNumber .= mt_rand(0, 9);
    }

    return $prefix . $randomNumber;
}
?>