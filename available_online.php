<?php
/********************************/
/* Course : COEN 276, Web Programming
/* Final Project, Chat Server
/* Name: Marufa Rahmi
/* Std id: w1128039*/



session_start();

		/* This PhP file selects all the user who are on-line */
		$urname = $_SESSION['name'];		
		try {
					
			$dbconn = new PDO("mysql:dbname=chatserver;host=localhost","root", "");
			$dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			$query_string = "SELECT user_id FROM available_user WHERE user_id != '$urname' ORDER BY user_id";
			$result1 = $dbconn->query($query_string);
					
			$availableonline = "";
			foreach($result1 as $row) {
				$availableonline .= "<div class='msgln'><b>". $row['user_id']. "<br></div>";	
			}
	
		} catch  (PDOException $e) {
			print_r($e->getMessage());    		
			die();
		}
		echo $availableonline; 

?>