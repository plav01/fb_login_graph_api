<?php

session_start();

require_once 'Facebook/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '648384022292884', // Replace {app-id} with your app id
  'app_secret' => '5caa6a9e744c2dff3bcf72f6b684802f',
  'default_graph_version' => 'v3.3',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://localhost/facebook/callback.php', $permissions);

header("location:" . $loginUrl);

?>