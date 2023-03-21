<?php
session_start(); // Starting session
// Importing db module and config file
require_once('db.php');
require_once('config.php');

// Checking if user has a ssesion like already logged in
if (!isset($_SESSION['isLogged'])){
    // Checking for emptying code variable from url
    if (isset($_GET['code'])) {
        // Making post requests to the google using $_GET['code'] var for getting access_token
        $code = $_GET['code'];
        $token_url = 'https://www.googleapis.com/oauth2/v4/token';
        $redirect_uri = 'http://'.$_SERVER['SERVER_NAME'].'/index.php';
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
        // Using function stream_context_create for add parametrs into request, cause I use file_get_contents function
        $context  = stream_context_create($options);
        $response = file_get_contents($token_url, false, $context);
        $response = json_decode($response, true); // Decoding json resoponse into php array
        $access_token = $response['access_token']; 
        
        if (isset($access_token)) {
            $db = new Database($db_host, $db_user, $db_pass, $db_name); // Creating object db
            $url = 'https://www.googleapis.com/oauth2/v3/tokeninfo?access_token=' . $access_token;
            // Making request to get more inforamtion by access token
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            $google_data = json_decode($response, true); //Decoding json resoponse into php array

            if ($db->register($google_data['aud'], $google_data['email'])){ // Checking is registering was successfull
                $_SESSION['isLogged'] = 'true'; // Adding session
                require_once('/template/default.php'); // Showing main php content
            } else {
                echo "Error 500";
            }
        } else {
            echo "Ошибка access token";
        }
    } else {
        header('Location: http://'.$_SERVER['SERVER_NAME'].'/login.php');
        // echo "Ошибка code Необходимо авторизоваться!";
    }

} else {
    require_once('/template/default.php');
}