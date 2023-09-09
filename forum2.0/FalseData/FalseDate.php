<?php
require_once 'vendor/autoload.php';

$faker = Faker\Factory::create();

$data = [];
for ($i = 0; $i < 50; $i++) {
    $data[] = [
        'id' => $faker->uuid,
        'title' => $faker->sentence,
        'content' => $faker->paragraph,
        'publish_time' => $faker->dateTimeThisYear->format('Y-m-d H:i:s'),
        'views' => $faker->numberBetween(0, 1000),
        'replies' => $faker->numberBetween(0, 100),
        'user_id' => $faker->randomNumber(6),
        'category_id' => $faker->randomNumber(3),
    ];
}

foreach ($data as $item) {
    print_r($item);
    echo PHP_EOL;
}
?>
