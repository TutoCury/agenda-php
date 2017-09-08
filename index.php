<?php

//phpinfo(); exit;
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'src/util/Application.php';
$app = new Application();
$app->dispatch();
