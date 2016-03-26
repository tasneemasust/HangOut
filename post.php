<?php

/********************************/
/* Course : COEN 276, Web Programming
/* Final Project, Chat Server
/* Name: Marufa Rahmi
/* Std id: w1128039*/


session_start();

/* this php file inserts messages in to chat_history table */

if(isset($_SESSION['name'])){
   $text = $_POST['text'];
	
	
	
	$urname = $_SESSION['name']; /* take urname from session*/
	$msg = stripslashes(htmlspecialchars($text)); /* trim the text message */	
	$date = date("Y-m-d H:i:s"); /* take system date */
	$frndname = $_SESSION['friend2'];
	   
   try {
		/* connect to database */
		$dbconn = new PDO("mysql:dbname=chatserver;host=localhost","root", "");
	    $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	
		/*  if user is in public chat save message in to chat_history */
		/*  otherwise save message in to private_chat */
		
		if($_SESSION['private'] == 'no'){
			$query_string = "INSERT INTO chat_history(user_id, message,time) VALUES ('$urname', '$msg','$date')";
		}
		
		
		else{
			
			/*if friend2 is not online save it to unread message */
			$query = "SELECT user_id FROM available_user";
			$res = $dbconn->query($query);
			$flag = true;	
			
			foreach($res as $row) {
				if($row["user_id"] == $frndname){
					$flag = false;
					break;
				}
			}
			
			if($flag){
				$query = "insert into unread_chat values ('$urname','$frndname')";
				echo $query;
				$dbconn->query($query);				
			}
			
			$query_string = "INSERT INTO private_chat  VALUES ('$urname','$frndname', '$msg','$date')";
		}
		
		$dbconn->query($query_string);
		
	
	} catch  (PDOException $e) {
    		print_r($e->getMessage());
    		
    		die();
	}
}
?>
