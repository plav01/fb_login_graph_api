<?php

session_start();

require_once 'Facebook/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '{Your app-id}', // Replace {app-id} with your app id
  'app_secret' => '{Your app-secret}',
  'default_graph_version' => 'v3.3',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://localhost/facebook/callback.php', $permissions);

header("location:" . $loginUrl);

?>
