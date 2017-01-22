<?php
ob_start();
session_start();
if (isset($_SESSION[username])) {
	$pageTitle='Dashboard';
	
	
include 'temp.php';
//Call Latestusers
$lastuser=4;
$theletst=getLatest("*","users","userid",$lastuser);
/*start dashbord page
*/
?>
<div class="container home-stats text-center">
  <h1>Dashboard</h1>
	<div class="row">
		<div class="col-md-3">
			<div class="stat st-member">Total Members<span><a href="members.php"><?php echo countItems('userid','users'); ?></a></span></div>
		</div>
		<div class="col-md-3">
			<div class="stat st-pending">Pending Members<span><a href="members.php?do=Manage&page=pending"><?php echo checkItem('regstatus','users',0); ?></a></span></div>
		</div>
		<div class="col-md-3">
			<div class="stat st-items">Total Items<span><a href="items.php"><?php echo countItems('Items_ID','items'); ?></a></span></div>
		</div>
		<div class="col-md-3">
			<div class="stat st-comment">Total Comments<span>123</span></div>
		</div>
   </div>
</div>
<div class="container latest">
	 <div class="row">
		   <div class="col-md-6">
			  <div class="panel panel-default">
				   <div class="panel-heading">
				      
					<i class="fa fa-users"></i>Latest Register Users = <?php echo $lastuser ?>
				   </div>
			      
			       <div class="panel-body">
			       <ul class="list-unstyled latest-users">
				   			   <?php
                                
                                  foreach ($theletst as $user) {
	                                     echo '<li>'.$user['username'].'<a href="members.php?do=Edit&userid='.$user['userid'].'"><span class="btn btn-success pull-right"><i class="fa fa-edit">Edit</i></span></a>';
	                                     if ($user['regstatus']==0) {

					echo"<a href='members.php?do=Active&userid=" . $user['userid'] . "' class='btn btn-info active pull-right'><i class='fa fa-close'></i> Active </a></td>";
				
			}
			echo '</li>';
                                          }
                                 ?>
                    </ul>

				   </div>
			   </div>
		   </div>
		   <div class="col-md-6">
			  <div class="panel panel-default">
				   <div class="panel-heading">
					<i class="fa fa-tags"></i>Latest Items
				   </div>
			      
			       <div class="panel-body">
	

				   </div>
			   </div>
		   </div>
	</div>
</div>

<?php
include $tmp.'footer.inc';
}else {
	header('location: index.php');
	exit();
}
ob_end_flush();
?>