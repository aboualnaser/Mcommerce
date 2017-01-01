<?php

function lang($phrase){
	static $lang =array(
		'message'=>'welecom',
        'admin' =>'administrator',
        'Home'=>'home'
		);
	return $lang[$phrase];
}


/*
$lang= array(
	'osamas' => 'elzer'
)
;
echo $lang['osamas'];
*/
