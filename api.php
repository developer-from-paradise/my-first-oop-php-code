<?php
include('module.php');
header('Content-Type: application/json; charset=utf-8');
$query = $_POST['requests'];
$api = new webSearchAPI();
$api::$pagesize = "20";
$api::$autocorrect = "true";

$data = $api->get_data($query);
echo json_encode($data);

?>