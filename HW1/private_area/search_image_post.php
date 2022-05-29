<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: ../log/startingpage.php");
    exit;
}

$access_key = 'M5ihkzEt5p-za4CO7Aqks7uBfYY5JOUYXZjyovqly4g';
$secret_key = 'KfB4otSUFxaY_RonzMTiX-J4OGC0_EtRpEWzMXq_K_E';

$url = 'https://api.unsplash.com/search/photos?client_id='.$access_key.'&per_page=30&order_by=relevant&'.http_build_query(array('query' => $_GET['q']));

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL,$url);
curl_setopt($curl , CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);

$result = array(json_decode($result,true));
$res = array();
for($i = 0; $i<count($result[0]['results']); $i++) {
    $res[] = $result[0]['results'][$i]['urls']['small'];
}

curl_close($curl);

echo json_encode($res);
?>