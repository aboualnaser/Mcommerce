<?php

/* this function echo the title in evert page */
function getTitle(){
	global $pageTitle;
	if(isset($pageTitle)){
		echo $pageTitle;
	}
	else {
		echo "Default";
	}
}