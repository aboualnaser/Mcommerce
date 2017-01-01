<?php
$dsn='mysql:host=localhost;dbname=shop';
$user='root';
$pass='root';
try{
	$con =new PDO($dsn,$user,$pass);

}
catch(PDOException $e){
	echo "failed to connect".$e->getMessage();
}
