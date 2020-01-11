<?php
require "vendor/autoload.php";

/*
*	BladeOne Viewengine aufsetzen
*/

use eftec\bladeone\BladeOne;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';
$blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);

include ('snippets/mysqlconnect.php');
include ('login_auth.php');

echo $blade->run("login2",array("display2"=> $display));