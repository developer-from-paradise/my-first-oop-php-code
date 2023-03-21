<?php
session_start();
require_once('db.php');
require_once('config.php');


if (!isset($_SESSION['isLogged'])){
    if (isset($_GET['code'])) {
        $code = $_GET['code'];
    
        $token_url = 'https://www.googleapis.com/oauth2/v4/token';
        $redirect_uri = "http://localhost/session/openAI/index.php";
        $data = array(
            'code' => $code,
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'redirect_uri' => $redirect_uri,
            'grant_type' => 'authorization_code'
        );
    
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
    
        $context  = stream_context_create($options);
        $response = file_get_contents($token_url, false, $context);
        $response = json_decode($response, true);
        $access_token = $response['access_token'];
    
        if (isset($access_token)) {
            $db = new Database($db_host, $db_user, $db_pass, $db_name);
            $url = 'https://www.googleapis.com/oauth2/v3/tokeninfo?access_token=' . $access_token;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $google_data = json_decode($response, true);
            if ($db->register($google_data['aud'], $google_data['email'])){
                $_SESSION['isLogged'] = 'true';
                require_once($_SERVER['DOCUMENT_ROOT'].'/session/openAI/template/default.php');
            } else {
                echo "Error 500";
            }
        } else {
            echo "Ошибка access token";
        }
    } else {
        header('Location: http://localhost/session/openAI/login.php');
        // echo "Ошибка code Необходимо авторизоваться!";
    }

} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/session/openAI/template/default.php');
}