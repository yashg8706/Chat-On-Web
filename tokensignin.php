<?php
  require_once 'vendor/autoload.php';
    session_start();
    $CLIENT_ID="600204595997-08kk9h71vgmus0me76gikhboeg3r5rnb.apps.googleusercontent.com";
    $id_token=$_POST['idtoken'];
    $client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
    
    $payload = $client->verifyIdToken($id_token);
    if ($payload) {
    $userid = $payload['sub'];
    // If request specified a G Suite domain:
    //$domain = $payload['hd'];
    $_SESSION['username'] = $payload['name'];
    } else {
    // Invalid ID token
    }