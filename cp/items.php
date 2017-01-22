<?php
ob_start();

/*
===Items Page
== You Can Add |Edit |Delete Items From Here
============================================
*/
$pageTitle='Members';
session_start();
if (isset($_SESSION[username])) {
		include 'temp.php';
		$do =isset($_GET['do']) ? $_GET['do']:'Manage';
		if ($do=='Manage') {
		//Manage Page
			
					
					$stmt = $con->prepare("SELECT 
										items.*, 
										categories.name AS category_name, 
										users.username 
									FROM 
										items
									INNER JOIN 
										categories 
									ON 
										categories.id = items.CAT_ID 
									INNER JOIN 
										users 
									ON 
										users.userid = items.Member_ID
									ORDER BY 
										Items_ID DESC");
					// Execute The Statement
					$stmt->execute();
					// Assign To Variable 
					$items = $stmt->fetchAll();
					if (! empty($items)) {


			?>
			


				<h1 class="text-center">Manage Items</h1>
				<div class="container">
		        <div class="table-responsive">
		        <table class="main-table table table-bordered">
		        <tr>
		        	<td>#ID</td>
		        	<td>Name</td>
		        	<td>Description</td>
		        	<td>Price</td>
		        	<td>Adding Date</td>
		        	<td>Categories</td>
		        	<td>User Name</td>
		        	<td>Control</td>
		        </tr>
		        <?php
					foreach($items as $item) {
						echo "<tr>";
						echo "<td>" . $item['Items_ID'] . "</td>";
						echo "<td>" . $item['Name'] . "</td>";
						echo "<td>" . $item['Description'] . "</td>";
						echo "<td>" . $item['Price'] . "</td>";
						echo "<td>" . $item['ADD_Date'] . "</td>";
						echo "<td>" . $item['category_name'] . "</td>";
						echo "<td>" . $item['username'] . "</td>";
						echo "<td>
							<a href='members.php?do=Edit&itemid=" . $item['Items_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
							<a href='members.php?do=Delete&itemid=" . $item['Items_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
						
						
					
					echo "</tr>";
									}
								}

								?>
		       
		        

		        </table>
		        </div>
		        <a href="items.php?do=Add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>New Item</a>
				</div>

		<?php
			}
		elseif ($do == 'Add') {
		    //Add Page
		    ?>
		 <h1 class="text-center">Add New Items</h1>
		<div class="container">
			<form class="form-horizontal" action="?do=Insert" method="POST">
			
			    <!-- Start Name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="name" 
								class="form-control" 
								required="required"  
								placeholder="Name of The Item" />
						</div>
					</div>
					<!-- End Name Field -->
					<!-- Start Description Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="description" 
								class="form-control" 
								required="required"  
								placeholder="Description of The Item" />
						</div>
					</div>
					<!-- End Description Field -->
					<!-- Start Price Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Price</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="price" 
								class="form-control" 
								required="required" 
								placeholder="Price of The Item" />
						</div>
					</div>
					<!-- End Price Field -->
					<!-- Start Country Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Country</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="country" 
								class="form-control" 
								required="required" 
								placeholder="Country of Made" />
						</div>
					</div>
					<!-- End Country Field -->
					<!-- Start Status Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10 col-md-6">
							<select name="status">
								<option value="0">...</option>
								<option value="1">New</option>
								<option value="2">Like New</option>
								<option value="3">Used</option>
								<option value="4">Very Old</option>
							</select>
						</div>
					</div>
             <!-- End Status Field -->
             <!-- Start All Members Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Members</label>
						<div class="col-sm-10 col-md-6">
							<select name="member">
								<option value="0">...</option>
							<?php $stmt=$con->prepare("SELECT * FROM users");	
							$stmt->execute();
							$users=$stmt->fetchAll();
							foreach ($users as $user) {
								echo "<option value='".$user['userid']."'>".$user['username']."</option>";
							}
							?>
							</select>
						</div>
					</div>
             <!-- End All Members Field -->
             <!-- Start All Members Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Categories</label>
						<div class="col-sm-10 col-md-6">
							<select name="category">
								<option value="0">...</option>
							<?php $stmt=$con->prepare("SELECT * FROM categories");	
							$stmt->execute();
							$cats=$stmt->fetchAll();
							foreach ($cats as $cat) {
								echo "<option value='".$cat['id']."'>".$cat['name']."</option>";
							}
							?>
							</select>
						</div>
					</div>
             <!-- End All Members Field -->
             <!--Start Add Submint Field -->
              <div class="form-group form-group-lg">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" value="Add Items"  class="btn btn-primary btn-lg"/>
					</div>
				</div>
				<!--End Submint Field -->
			</form>
            </div>
           

<?php  
		    
		}

		elseif ($do == 'Insert') {
			//Insert Page
			if ($_SERVER['REQUEST_METHOD']=='POST') {

		echo "<h1 class='text-center'>Add Items</h1>";
	    echo "<div class='container'>";
		//GetVariable From Form
		$id     =$_POST['id'];
		$name   =$_POST['name'];
		$desc   =$_POST['description'];
		$price  =$_POST['price'];
	    $country=$_POST['country'];
	    $status =$_POST['status'];
	    $member = $_POST['member'];
		$cat    = $_POST['category'];


	$formerror=array();
	

	if (empty($name)) {
		$formerror[]='name Can\'t Be <strong>Empty</strong>';
	}
	if (empty($desc)) {
		$formerror[]='Description Can\'t Be <strong>Empty</strong>';
	}
	if (empty($price)) {
		$formerror[]='Price Can\'t Be <strong>Empty</strong>';
	}
	if (empty($country)) {
		$formerror[]='Country Can\'t Be <strong>Empty</strong>';
	}
	if ($status==0) {
		$formerror[]='You must chose <strong>Value</strong>';
	}
	if ($member == 0) {
		$formerror[] = 'You Must Choose the <strong>Member</strong>';
	}
	if ($cat == 0) {
		$formerror[] = 'You Must Choose the <strong>Category</strong>';
	}

	foreach ($formerror as $error) {
		echo '<div class="alert alert-danger">'.$error.'</div>';
	}

	//Check If There Is not Errors

	if (empty($formerror)) {



		// Insert In DataBase

		$stmt = $con->prepare("INSERT INTO 
								items(Name,
								 Description,
								 Price,
								 Country_Make,
								 Status,
								 ADD_Date,
								 CAT_ID,
								 Member_ID)
								VALUES(:zname, 
								       :zdesc, 
								       :zprice, 
								       :zcountry,
								       :zstatus,
								        now(),
								       :zcat,
								       :zmember)");
							$stmt->execute(array(
								'zname'      => $name,
								'zdesc'      => $desc,
								'zprice'     => $price,
								'zcountry'   => $country,
								'zstatus'    => $status,
								'zcat'       => $cat,
								'zmember'    => $member
							));
			// Echo Success Message
		$theMsg = "<div class='alert alert-success'>". $stmt->rowCount().'Record Inserted</div>';
	    redirectHome($theMsg,'back');
	
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
			// Edit Page
			
		   }

		elseif ($do == 'Update') {
		   
		    // Edit Page
				}


		elseif ($do == 'Approve'){
				
			// Active Page
				  
				}
	
      include $tmp.'footer.inc';
    }
else {
	header('location: index.php');
	exit();
}
ob_end_flush();