<?php

function db_connect(){
	$dsn = 'mysql:host=localhost;dbname=co_19_173_99sv_coco_com;charset=utf8';
	$user = 'co-19-173.99sv-c';
	$password = 'dD9fet3W';

	try{
		$dbh = new PDO($dsn, $user, $password);
		return $dbh;
	}catch (PDOException $e){
	    	print('Error:'.$e->getMessage());
	    	die();
	}
}

?>
