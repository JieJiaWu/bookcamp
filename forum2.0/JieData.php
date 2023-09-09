<?php
require_once "Sql_Login.php";
$pdo->exec("TRUNCATE TABLE `post`");

$titles = [
    "Lorem Ipsum",
    "Dolor Sit Amet",
    "Consectetur Adipiscing",
    "Elit Sed Do",
    "Eiusmod Tempor",
    "Incididunt Ut",
    "Labore Et",
    "Dolore Magna",
    "Aliqua Ut",
    "Enim Ad Minim",
    "Veniam Quis",
    "Nostrud Exercitation",
    "Ullamco Laboris",
    "Nisi Ut",
    "Aliquip Ex",
    "Ea Commodo",
    "Consequat Duis",
    "Aute Irure",
    "Reprehenderit Voluptate",
    "Esse Cillum",
    "Fugiat Nulla",
    "Pariatur Excepteur",
    "Sint Occaecat",
    "Cupidatat Non",
    "Proident Sunt",
    "Officia Deserunt",
    "Mollit Anim",
    "Est Laborum",
    "Ipsa Quae",
    "Ab Illo",
    "Dignissimos Ducimus",
    "Temporibus Autem",
    "Et Harum",
    "Quidem Rerum",
    "Facilis Est",
    "Expedita Distinctio",
    "Nam Libero",
    "Tempore Cum",
    "Soluta Nobis",
    "Omnis Voluptas"
];

$categories = [
    1,
    2,
    3,
    4,
    5
];

$userIds = [
    1,
    2,
    3,
    4,
    5
];

for ($i = 0; $i < 40; $i++) {
    $title = $titles[rand(0, count($titles) - 1)];
    $content = "This is the content of post number " . ($i + 1);
    $publish_time = date('Y-m-d H:i:s');
    $views = rand(100, 1000);
    $replies = rand(0, 50);
    $user_id = $userIds[rand(0, count($userIds) - 1)];
    $category_id = $categories[rand(0, count($categories) - 1)];

    $insertStmt = $pdo->prepare("INSERT INTO `post`(`title`, `content`, `publish_time`, `views`, `replies`, `user_id`, `category_id`) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insertStmt->execute([$title, $content, $publish_time, $views, $replies, $user_id, $category_id]);
}

echo "假数据生成完成！";
?>