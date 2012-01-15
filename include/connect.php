<?php
  
include_once "db/mysql.php";
$db=DbSimple_Generic::connect("mysql://".DB_User.":".DB_Password."@".DB_Host."/".DB_Databse);

function databaseErrorHandler($message, $info)
{

	if (!error_reporting()) return;

	echo "SQL Error: $message<br><pre>"; 
	print_r($info);
	echo "</pre>";
	exit();
}


?>
