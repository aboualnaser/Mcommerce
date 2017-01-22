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
			}
		elseif ($do == 'Add') {
		    //Add Page
		 
		    
		}

		elseif ($do == 'Insert') {
			//Insert Page
		}


		elseif ($do == 'Edit') {
			// Edit Page
			
		   }

		elseif ($do == 'Update') {
		   
		    // Edit Page
				}


		elseif ($do == 'Active'){
				
			// Active Page
				  
				}
	
      include $tmp.'footer.inc';
    }
else {
	header('location: index.php');
	exit();
}
ob_end_flush();