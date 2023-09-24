<?php
header ('Content-Type: text/html; charset=utf-8');
ini_set("display_errors", "stderr");error_reporting(E_ALL);
$month = date('m',time());
$day = date('d',time());
$url="http://home.2ui.top/htapi/bdbkmirrow/".$month.'.json';
$data = file_get_contents($url);
$data2 = json_decode($data,true);
$array = [];
foreach($data2[$month][$month.$day] as $data){
    $array[] = [
         'year'=>$data['year'],
         'title'=>$data['title']
     ];
}
$json_output = [
    $month.$day => $array
        ];
//输出
//header('Content-type:text/json');
//echo json_encode($json_output,true);

$data = $json_output;

foreach ($data[$month.$day] as $index => $item) {
    $year = $item['year'];
    $title = $item['title'];

    echo "序号:" . ($index + 1) ."\n";
    echo "年份:" . $year . '-'.$month.'-'.$day ."\n";
    echo "事件:" . $title ."\n";
}
