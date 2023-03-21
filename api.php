<?php
require_once('module.php');
require_once('config.php');

header('Content-Type: application/json; charset=utf-8');

$query = $_POST['requests'];
$module = new webSearchAPI();
$module::$pagesize = "20";
$module::$autocorrect = "true";

$GoogleData = $module->useGoogle($apiGoogle, $query);
$GPTData = $module->useChatGPT($apiGPT, $query);

$jsonmerge = (object) array_merge((array) json_decode($GPTData), (array) json_decode($GoogleData));
$data = json_encode($jsonmerge);

echo $data;


?>