<?php
require_once "Sql_Login.php";
// $id = $_GET['id'];

$output = [
    'success' => false,
    'errorMessage' => '',
    'data' => $_POST

];

try {
    if (isset($_GET['id'])) {
        $sql = "DELETE FROM `post` WHERE id=?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        header("location:page_Select.php");
        echo "<script>alert('刪除成功')</script>";
    }
    ;

} catch (Exception $ex) {
    echo "Error" . $ex->getMessage();
}



try {

    if (isset($_POST['querytag'])) {
        $ids = $_POST['querytag'];
        foreach ($ids as $id) {
            $sql = "DELETE FROM `post` WHERE id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
        }
    }
    $output['success'] = true;

    header("location:page_Select.php");
    echo "<script>alert('刪除成功')</script>";
} catch (Exception $ex) {
    echo "Error" . $ex->getMessage();
}
echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>