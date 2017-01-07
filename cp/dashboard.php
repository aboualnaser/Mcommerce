<?php
session_start();
if (isset($_SESSION[username])) {
	$pageTitle='Dashboard';
include 'temp.php';
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
			<div class="stat st-items">Total Items<span>32</span></div>
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
				   <?php  $lastuser=4; ?>
					<i class="fa fa-users"></i>Latest Register Users = <?php echo $lastuser ?>
				   </div>
			      
			       <div class="panel-body">
				   			   <?php
                                $theletst=getLatest("*","users","userid",$lastuser);
                                  foreach ($theletst as $user) {
	                                     echo $user['username'].'<br>';
                                          }
                                 ?>


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