<?php

function lang($phrase){
  static $lang =array(
    'message'    =>'bienvenue',
        'admin'      =>'administrateur',
        'Categories' =>'Categories',
        'Members'    =>'Members',
        'Statistics' => 'Statistics',
        'Logs'       =>'Logs',
        'Home'       =>'Accuiel',
        'Items'      =>'Items',
        'Logs'       =>'Logs'
    );
  return $lang[$phrase];
}
?>


