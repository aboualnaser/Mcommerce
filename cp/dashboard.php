<?php
session_start();
if (isset($_SESSION[username])) {
	$pageTitle='Dashboard';
include 'temp.php';
include $tmp.'footer.inc';
}else {
	header('location: index.php');
	exit();
}