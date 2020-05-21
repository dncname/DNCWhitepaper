<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 如果私人用的，那么设置下权限
//auth();

$config = require "./config.php";

require './pdf.php';
require './views/header.php';
require './views/main.php';
require './views/footer.php';

function auth(){
	if (!(($_SERVER['PHP_AUTH_USER'] == 'hello') && ($_SERVER['PHP_AUTH_PW'] == 'hello'))) {
		header('WWW-Authenticate: Basic realm="Login:"');
		header('HTTP/1.0 401 Unauthorized');
		die("Not authorized!!!");
	}
}
