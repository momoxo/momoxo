<?php
/* 画像加工のためのモジュール */
include ('../../mainfile.php');

//url=http://localhost/hokusai/home/themes/hokusai_pre/images/header.jpg&width=60&height=60&kind=square

//
$param = array();

foreach($_GET as $key=>$value){
    $param[$key] = htmlspecialchars($value);
}

momoimage::createThumbnail($param['url'], '', $param['width'], $param['height'], $param['kind']);

?>