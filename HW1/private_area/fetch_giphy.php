<?php
session_start();
if(!isset($_SESSION["username"]))
{
    header("Location: ../log/startingpage.php");
    exit;
}

$apikey_giphy = 'qFHu0yH2PcFWEkDSGyH26AUR6aX6PwCN';
$endpoint = 'api.giphy.com/v1/gifs/search';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $endpoint.'?apikey='.$apikey_giphy.'&q='.urlencode($_POST['keyword']).'&limit=50');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);

$result_array = array(json_decode($result,true));
$res = array();
foreach($result_array[0]['data'] as $elem) {
    if($elem['images']['downsized']['height'] === $elem['images']['downsized']['width']) {
        $res[] = $elem['images']['downsized']['url'];
    }
}

echo json_encode($res);

curl_close($curl);
?>