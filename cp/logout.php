<?php
session_start();   //Start The Session
session_unset();   //Unset the Data
session_destroy(); //Destroy The Session
header('location: index.php');
exit();