<?php
//connect with database
include "conn.php";
//Routes
$tmp="includes/templates/";
$lang="includes/languages/";
$func="includes/functions/";


//include the important files
include $func."function.php";
include $lang."french.php";
include $tmp."header.inc";





//include navbar on all pages except the one with navbar variable
if (!isset($nonavbar)) { 
	include $tmp.'navbar.php';
 	
 } 