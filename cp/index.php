<?php
session_start();
$nonavbar='';
$pageTitle='Login';
if (isset($_SESSION[username])) {

	header('location:dashboard.php');
}
include "temp.php";

if( isset($_POST['login']) ) {
	$username=$_POST['user'];
	$password=$_POST['password'];
	$hashedpass=sha1($password);
    $stmt=$con->prepare("SELECT userid, username,password FROM users WHERE username =? AND password=? AND groupid=1 
    	LIMIT 1");
    $stmt->execute(array($username,$hashedpass));
    $row =$stmt->fetch();
    $count=$stmt->rowCount();
    if ($count>0) {
    	$_SESSION['username']=$username; //Register session name
    	$_SESSION['ID']=$row['userid'];
    	//Register session ID
    	header('location:dashboard.php');  //redirect dashboard
    	exit();
    }
}
?>
<form class="login" action="#" method="post">
    <h4 class="text-center">Admin Login</h4>
	<input class="form-control" type="text" name="user" placeholder="username" autocomplete="off"/ >
	<input class="form-control" type="password" name="password" placeholder="password" autocomplete="new-password"/ >
	<input class="btn btn-primary btn-block" name="login" type="submit" value="login"/>

</form>
<?php
include $tmp."footer.inc";
?>