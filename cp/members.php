<?php
ob_start();

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
$do =isset($_GET['do']) ? $_GET['do']:'Manage';
if ($do=='Manage') {

	//Manage Page
	$query='';
	if (isset($_GET['page'])&& $_GET['page']=='pending') {
		$query= 'AND regstatus = 0';
	}

// Select All Users Except Admin 
			$stmt = $con->prepare("SELECT * FROM users WHERE groupid != 1 $query");
			// Execute The Statement
			$stmt->execute();
			// Assign To Variable 
			$rows = $stmt->fetchAll();
			if (! empty($rows)) {


	?>
	


		<h1 class="text-center">Manage Members</h1>
		<div class="container">
        <div class="table-responsive">
        <table class="main-table table table-bordered">
        <tr>
        	<td>#ID</td>
        	<td>Username</td>
        	<td>Email</td>
        	<td>FullName</td>
        	<td>Register Date</td>
        	<td>Control</td>
        </tr>
        <?php
			foreach($rows as $row) {
				echo "<tr>";
				echo "<td>" . $row['userid'] . "</td>";
				echo "<td>" . $row['username'] . "</td>";
				echo "<td>" . $row['email'] . "</td>";
				echo "<td>" . $row['fullname'] . "</td>";
				echo "<td>" . $row['date'] . "</td>";
				echo "<td>
					<a href='members.php?do=Edit&userid=" . $row['userid'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
					<a href='members.php?do=Delete&userid=" . $row['userid'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
				
				if ($row['regstatus']==0) {

					echo"<a href='members.php?do=Active&userid=" . $row['userid'] . "' class='btn btn-info active'><i class='fa fa-close'></i> Active </a></td>";
				
			}
			echo "</tr>";
							}
						}

						?>
       
        

        </table>
        </div>
        <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>New Member</a>
		</div>

<?php
}

elseif ($do == 'Add') {
    //Add Page
     
     ?>
	
		<h1 class="text-center">Add New Members</h1>
		<div class="container">
			<form class="form-horizontal" action="?do=Insert" method="POST">
			
			    <!--Start Username Field --> 
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Username</label>
					<div class="col-sm-10 col-md-4">
						<input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Username To Login To Shop" />
					</div>
				</div>
				<!--End Username Field -->
				<!--Start Password Field --> 
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Password</label>
					<div class="col-sm-10 col-md-4">
					<input type="password" name="password" required="required" placeholder="Password Must Be Strong" class="password form-control" autocomplete="off"/>
					<i class="show-pass fa fa-eye fa-2x"></i>
					</div>
				</div>
				<!--End Password Field -->
				<!--Start Email Field --> 
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10 col-md-4">
						<input type="email" name="email" class="form-control" required="required" placeholder="Enter Email" />
					</div>
				</div>
				<!--End Email Field -->
				<!--Start Full Name Field --> 
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Full Name</label>
					<div class="col-sm-10 col-md-4">
						<input type="text" name="full" class="form-control" required="required" placeholder="Full name " />
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

elseif ($do == 'Insert') {
	
	if ($_SERVER['REQUEST_METHOD']=='POST') {

		echo "<h1 class='text-center'>Add New Members</h1>";
	    echo "<div class='container'>";
		//GetVariable From Form
		$id    =$_POST['userid'];
		$user  =$_POST['username'];
		$email =$_POST['email'];
		$name  =$_POST['full'];
	    $password=$_POST['password'];
	    $hashpass=sha1($password);
	    //Validate The Form
	$formerror=array();
	if (strlen($user)<3) {
		$formerror[]='Username Cant Be less Than 6 chars';
	}

	if (empty($user)) {
		$formerror[]='Username Cant Be <strong>Empty</strong>';
	}
	if (empty($password)) {
		$formerror[]='Password Cant Be <strong>Empty</strong>';
	}
	if (empty($name)) {
		$formerror[]='Full name Cant Be <strong>Empty</strong>';
	}
	if (empty($email)) {
		$formerror[]='Email Cant Be <strong>Empty</strong>';
	}
	foreach ($formerror as $error) {
		echo '<div class="alert alert-danger">'.$error.'</div>';
	}
	//Check If There Is not Errors

	if (empty($formerror)) {

	//Check If User Is Exist in Databasse
		                  
	    $check=checkItem('username', 'users', $user);
		if ($check==1) {
		$existuser= '<div class="alert alert-danger">Sorry This User Is Exist</div>';
		
	redirectHome($existuser,6);
		}
		else{


		// Insert In DataBase

		$stmt = $con->prepare("INSERT INTO 
								users(username, password, email,fullname,regstatus,date)
								VALUES(:zuser, :zpass, :zmail, :zname,
								     0,
								     now())");
							$stmt->execute(array(
								'zuser' => $user,
								'zpass' => $hashpass,
								'zmail' => $email,
								'zname' => $name
							));
			// Echo Success Message
		$theMsg = "<div class='alert alert-success'>". $stmt->rowCount().'Record Inserted</div>';
	    redirectHome($theMsg,'back');
	}
	}
	}
	else{
		echo "<div class='container'>";
		$theMsg ='<div class="alert alert-danger">Sorry You Cant Brows This Page Directly</div>';
		redirectHome($theMsg,'back');
		echo "</div>";
    }
echo "</div>";
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
			<form class="form-horizontal" action="?do=Update" method="POST">
			<input type="hidden" name="userid" value="<?php echo $userid?>">
			    <!--Start Username Field --> 
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Username</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="username" class="form-control" value='<?php echo $row['username'] ?>' autocomplete="off" required="required" />
					</div>
				</div>
				<!--End Username Field -->
				<!--Start Password Field --> 
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Password</label>
					<div class="col-sm-10 col-md-6">
					<input type="hidden" name="oldpassword" value="'<?php echo $row['password']?>" />
					<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leve blank If You Do Not Want To Change" />
					</div>
				</div>
				<!--End Password Field -->
				<!--Start Email Field --> 
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10 col-md-6">
						<input type="email" name="email" class="form-control" value='<?php echo $row['email']?>'required="required"/>
					</div>
				</div>
				<!--End Email Field -->
				<!--Start Email Field --> 
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Full Name</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="full" class="form-control" value='<?php echo $row['fullname']?>' required="required"/>
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
       	echo "<div class='container'>";
       	$theMsg= "<div class='alert alert-danger'>There Is No Such ID</div>";
       	redirectHome($theMsg);
       	echo "</div>";
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
if (strlen($user)<3) {
	$formerror[]='Username Cant Be less Than 6 chars';
}

if (empty($user)) {
	$formerror[]='Username Cant Be <strong>Empty</strong>';
}
if (empty($name)) {
	$formerror[]='Full name Cant Be <strong>Empty</strong>';
}
if (empty($email)) {
	$formerror[]='Email Cant Be <strong>Empty</strong>';
}
foreach ($formerror as $error) {
	echo '<div class="alert alert-danger">'.$error.'</div>';
}
//Check If There Is not Errors

if (empty($formerror)) {
	
	// Update DataBase
	
	$stmt=$con->prepare("UPDATE users SET username=?,password=?,email=?,fullname=? WHERE userid=?");
	$stmt->execute(array($user,$password,$email,$name,$id));
	$theMsg="<div class='alert alert-success'>". $stmt->rowCount().'Record Updated</div>';
redirectHome($theMsg);
}
}
else{

	echo "<div class='container'>";
       	$theMsg= "<div class='alert alert-danger'>There Is No Such ID</div>";
       	redirectHome($theMsg);
       	echo "</div>";
}
echo "</div>";
}
elseif ($do == 'Delete') { // Delete Member Page
			echo "<h1 class='text-center'>Delete Member</h1>";
			echo "<div class='container'>";
				// Check If Get Request userid Is Numeric & Get The Integer Value Of It
				$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
				// Select All Data Depend On This ID
				$stmt=$con->prepare("SELECT * FROM users WHERE userid=? LIMIT 1");
				//Execute Query
				$stmt->execute(array($userid));
				// If There's Such ID Show The Form
				if ($stmt->rowCount()>0) {
					$stmt = $con->prepare("DELETE FROM users WHERE userid = :zuser");
					$stmt->bindParam(":zuser", $userid);
					$stmt->execute();
					$theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
					redirectHome($theMsg, 6);
				} else {
					$theMsg= '<div class="alert alert-danger">This ID is Not Exist</div>';
					redirectHome($theMsg,6);
				}
			echo '</div>';
		}
	elseif ($do == 'Active')
		# Active Page
		 { 
			echo "<h1 class='text-center'>Active Member</h1>";
			echo "<div class='container'>";
				// Check If Get Request userid Is Numeric & Get The Integer Value Of It
				$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
				// Select All Data Depend On This ID
				$check=checkItem('userid','users',$userid);
				// If There's Such ID Show The Form
				if ($check>0) {
					$stmt = $con->prepare("UPDATE users SET regstatus =1 WHERE userid = ?");
					$stmt->execute(array($userid));
					$theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Active</div>';
					redirectHome($theMsg, 6);
				} else {
					$theMsg= '<div class="alert alert-danger">This ID is Not Exist</div>';
					redirectHome($theMsg,6);
				}
			echo '</div>';
		}
	
include $tmp.'footer.inc';
}else {
	header('location: index.php');
	exit();
}
ob_end_flush();