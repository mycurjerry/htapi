<?php
header('Content-Type: text/html; charset=utf-8');
ini_set("display_errors", "stderr");
error_reporting(E_ALL);
$month = date('m', time());
$day = date('d', time());
$url = "http://home.2ui.top/htapi/bdbkmirrow/" . $month . '.json';
$data = file_get_contents($url);
$data2 = json_decode($data, true);
$array = [];
foreach ($data2[$month][$month . $day] as $data) {
    $array[] = [
        'year' => $data['year'],
        'title' => $data['title']
    ];
}
$json_output = [
    $month . $day => $array
];

// Output
$data = $json_output;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .item {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .item h2 {
            font-size: 18px;
            margin: 0;
        }
    </style>
</head>
<body>
<div class="container">
    <?php foreach ($data[$month . $day] as $index => $item) { ?>
        <div class="item">
            <h2>序号: <?php echo ($index + 1); ?></h2>
            <p>年份: <?php echo $item['year'] . '-' . $month . '-' . $day; ?></p>
            <p>事件: <?php echo $item['title']; ?></p>
        </div>
    <?php } ?>
</div>
</body>
</html>
