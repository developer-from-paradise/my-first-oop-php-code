<?php
session_start();
if (isset($_SESSION['isLogged'])){
    header('Location: http://localhost/session/openAI/index.php');
}else{
    require_once('config.php');
    $redirect_uri = "http://localhost/session/openAI/index.php"; 
    $url = 'https://accounts.google.com/o/oauth2/v2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email') . '&redirect_uri=' . urlencode($redirect_uri) . '&response_type=code&client_id=' . $client_id . '&access_type=online'; 
    require_once($_SERVER['DOCUMENT_ROOT'].'/session/openAI/template/login.php');
}