<?php
require_once('module.php'); // Imoporting library webSearch
require_once('config.php'); // Importing config file 

// Making page type application json not php page
header('Content-Type: application/json; charset=utf-8');

$query = $_POST['requests'];
$module = new webSearchAPI(); // Creating object of the webSearchAPI
$module::$pagesize = "20"; // Setting pagesize parametr of the google module
$module::$autocorrect = "true"; // Setting autocorrect parametr to true for correcting user requests

$GoogleData = $module->useGoogle($apiGoogle, $query); // using method useGoogle to get articles
$GPTData = $module->useChatGPT($apiGPT, $query); // using method useChatGPT to get answer from chatgpt

$jsonmerge = (object) array_merge((array) json_decode($GPTData), (array) json_decode($GoogleData)); // merging two datas
$data = json_encode($jsonmerge); // encoding array into json

echo $data; // returning json data


?>