<?php
require('../desksub/lib/simple.php');

$response   = request();
$lastUser   = @file_get_contents('last');

if($response !== false){
    $dom            = @str_get_html($response);
    $currentUser    = @trim($dom->find('.item-notif a .text', 0)->plaintext);
    if($currentUser && $currentUser != $lastUser) {
        file_put_contents('last', $currentUser);
        render($currentUser);
    }
}

function render($currentUser)
{
    echo '
        <html>
        <head>
            <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins" />
            <style>
                body {
                    border:none;
                    width: 100%;
                    height: 100%;
                    overflow: hidden;
                    margin: 0;
                    text-align: right;
                    position: relative;
                }
                div {
                    width: 600px;
                    position: absolute;
                    right: 0;
                }
                h1 {
                    position: absolute;
                    top: 130;
                    right: 25;
                    text-transform: uppercase;
                    color: #FFF;
                    margin: 0;
                    font-family: "Poppins", sans-serif;
                    width: 340px;
                    font-size: 20px;
                    overflow: hidden;
                    text-align: center;
                }
            </style>
        </head>
        <body>
            <div>
                <img src="assets/wel.png"/>
                <h1>'.$currentUser.'</h1>
            </div>
            <audio src="assets/wel.mp3" autoplay>
            <p>If you are reading this, it is because your browser does not support the audio element.</p>
            </audio>
        <body>
        </html>
    ';
}

function request()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.aparat.com/user/message/list');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Cookie: UR Cookie'
    ]);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    $response = curl_exec($ch); 
    curl_close($ch);
    return $response;
}
