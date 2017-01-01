<?php


/*
=============================================
== Mange Members Page
== You Can Add |Edit |Delete Member From Here
============================================
*/
$pageTitle='Members';
session_start();
if (isset($_SESSION[username])) {
include 'temp.php';
$do =isset($_GET['do']) ? $_GET['do']:'Mange';
if ($do=='Mange') {
	//Manage Page
	echo "Welecom In Manage Page";
}
elseif ($do == 'Edit') {
	// Edit
	$userid=isset($_GET['userid']) && is_numeric($_GET['userid'])?intval($_GET['userid']):0;


	$stmt=$con->prepare("SELECT * FROM users WHERE userid=? LIMIT 1");
	$stmt->execute(array($userid));
	$row=$stmt->fetch();
	$count=$stmt->rowCount();

	if ($count>0) {?>
	
		<h1 class="text-center">Edite Members</h1>
		<div class="container">
			<form class="from-horizontal" action="?do=Update" method="POST">
			<input type="hidden" name="userid" value="<?php echo $userid?>">
			    <!--Start Username Field --> 
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Username</label>
					<div class="col-sm-10">
						<input type="text" name="username" class="form-contol" value='<?php echo $row['username']?>' autocomplete="off" />
					</div>
				</div>
				<!--End Username Field -->
				<!--Start Password Field --> 
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Password</label>
					<div class="col-sm-10">
					<input type="hidden" name="oldpassword" class="form-contol" autocomplete="new-password" />
						<input type="password" name="newpassword" class="form-contol" autocomplete="new-password" />
					</div>
				</div>
				<!--End Password Field -->
				<!--Start Email Field --> 
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10">
						<input type="email" name="email" class="form-contol" value='<?php echo $row['email']?>'/>
					</div>
				</div>
				<!--End Email Field -->
				<!--Start Email Field --> 
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Full Name</label>
					<div class="col-sm-10">
						<input type="text" name="full" class="form-contol" value='<?php echo $row['fullname']?>'/>
					</div>
				</div>
				<!--End Full Name Field -->
				<!--Start Submit Field --> 
				<div class="form-group form-group-lg">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" value="save"  class="btn btn-primary btn-lg"/>
					</div>
				</div>
				<!--End Submint Field -->
			</form>
            </div>
           <?php 
       }
       else{
       	echo "There Is No Such ID";
           }
   }
 elseif ($do == 'Update') {
   
echo "<h1 class='text-center'>Update Members</h1>";
echo "<div class='container'>";
if ($_SERVER['REQUEST_METHOD']=='POST') {
	//GetVariable From Form
	$id    =$_POST['userid'];
	$user  =$_POST['username'];
	$email =$_POST['email'];
	$name  =$_POST['full'];
    $password='';
    if (empty($_POST['newpassword'])) {
    	$password=$_POST['oldpassword'];
    	}	
    else {$password=sha1($_POST['newpassword']);}
    //Validate The Form
$formerror=array();
if (strlen($user)<6) {
	$formerror[]='<div class="alert alert-danger">Username Cant Be less than 6 chars</div>';
}

if (empty($user)) {
	$formerror[]='<div class="alert alert-danger">Username Cant Be <strong>empty</strong></div>';
}
if (empty($name)) {
	$formerror[]='<div class="alert alert-danger">Full name Cant Be <strong>empty</strong></div>';
}
if (empty($email)) {
	$formerror[]='<div class="alert alert-danger">Email Cant Be <strong>empty</strong></div>';
}
foreach ($formerror as $error) {
	echo $error;
}
//Check If There Is not Errors

if (empty($formerror)) {
	
	// Update DataBase
	
	$stmt=$con->prepare("UPDATE users SET username=?,password=?,email=?,fullname=? WHERE userid=?");
	$stmt->execute(array($user,$password,$email,$name,$id));
	echo $stmt->rowCount().'Record Updated';
}
}
else{
	echo "Sorry You Can't Brows This Page Directly";
}
echo "</div>";
}
include $tmp.'footer.inc';
}else {
	header('location: index.php');
	exit();
}