<?php
session_start(); // 確保啟用 SESSION 功能
if (isset($_GET["logout"]) && ($_GET["logout"] == "true")) {
    unset($_SESSION["username"]);
    unset($_SESSION["id"]);
    header("Location:login.php");
    // echo "登出成功";
}
?>