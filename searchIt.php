<?php
/********************************/
/* Course : COEN 276, Web Programming
/* Final Project, Chat Server
/* Name: Marufa Rahmi
/* Std id: w1128039*/


	/* This php file searches database for partial name match */
	
if($_GET) {
	try {
		$dbconn = new PDO("mysql:dbname=chatserver;host=localhost",	"root", "");
		$dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
		if(isset($_GET['n_friend']) && $_GET['n_friend'] != "") {
			$query_string = "SELECT * FROM user WHERE last_name like '{$_GET['n_friend']}%' OR first_name like '{$_GET['n_friend']}%'";
			$rows = $dbconn->query($query_string);
			
			$result="";
		
			foreach($rows as $row) {
				$result .= $row['first_name'].' '.$row['last_name'].' -> User Name: '.$row['user_id']."\n";	
	
			}
		
			echo $result;
		}		

	} catch  (PDOException $e) {
		print_r($e->getMessage());
		
		die();
	}
	
}

?>