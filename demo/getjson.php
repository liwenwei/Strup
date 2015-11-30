<?php
header('Content-Type: application/json');
//header('Content-Type: text/html; charset=utf-8');

include '../HTTP/mycurl.php';

$url = 'http://huaban.com/favorite/beauty/?ihd8qpsz&since=534268926&limit=100&wfl=1';

$my_curl = new mycurl($url);
$my_curl->createCurl();
$result = $my_curl->__tostring();

echo $result;