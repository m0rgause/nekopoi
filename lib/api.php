<?php
include "nekopoi.php";
header("Content-type: application/json");
// call api
$api = new Nekopoi;

$get = isset($_GET['get']) ? $_GET['get'] : http_response_code(403) . die();
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$res = array('');

if ($get == 'latest') {
    $res = $api->latest($page);
}

if ($get == 'hentai') {
    if (empty($_GET['url'])) {
        $res = array("code" => 400, "message" => "bad request");
    } else {
        $res = $api->getH($_GET['url']);
    }
}
if ($get == 'series') {
    if (empty($_GET['url'])) {
        $res = array("code" => 400, "message" => "bad request");
    } else {
        $res = $api->getSeries($_GET['url']);
    }
}

if ($get == 'category') {
    if (empty($_GET['category_name'])) {
        $res = array("code" => 400, "message" => "bad request");
    } else {
        $res = $api->Category($page, $_GET['category_name']);
    }
}

if ($get == 'search') {
    if (empty($_GET['q'])) {
        $res = array("code" => 400, "message" => "bad request");
    } else {
        $res = $api->search($page, $_GET['q']);
    }
}

echo json_encode($res);
