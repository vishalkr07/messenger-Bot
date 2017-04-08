<?php
    $hubVerifyToken = 'chatbot';
    $accessToken = null;
    // check token at setup
    if (isset($_REQUEST['hub_verify_token'])&&$_REQUEST['hub_verify_token'] === $hubVerifyToken) {
    echo $_REQUEST['hub_challenge'];
    exit;
    }

    $address = "php://input";
    $message = file_get_contents($address);
    $message = json_decode($message);
    $obj=$message -> entry[0];
    $p_id= $obj -> id;
    $time= $obj -> time;
    $msg= $obj -> messaging[0];
    $s_id= $msg -> sender -> id;
    $r_id= $msg -> recipient -> id;
    $msg = $msg -> message;
    $text = $msg -> text;
    $token = "";

    $reply = "";

    $data = array(
        'recipient' => array('id' => "$s_id"),
        'message' => array('text' => "$reply")
    );
    $content = json_encode($data);
    $url = "https://graph.facebook.com/v2.6/me/messages?access_token=$token";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    if(!empty($msg)){
        $result = curl_exec($ch);
    }
?>
