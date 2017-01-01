<?php

/*



*/
$do= '';
if (isset($_GET['do'])) {

	$do = $_GET['do'];
}
else {
	$do = 'Manage';
}
 
 // If the page is the main page 
if ($do == 'Manage') {
echo "Welecom You Are In The Main Page ";
}
elseif ($do=='Add') {
	echo "You Are In The Add Category Page";
}
else {
	echo "Eroor There bIs Papge In This Name";
}