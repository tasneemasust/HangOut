
<?php
/********************************/
/* Course : COEN 276, Web Programming
/* Final Project, Chat Server
/* Name: Marufa Rahmi
/* Std id: w1128039*/

session_start();

	/* this php file retrieve data from chat_history table and echo them */

	$urname = $_SESSION['name'];
	

	/* The following two array declaration is for emoticons */
	/* first array contains symbols */
	/* second one contain image link*/
	
	$emo = array(":)", ":D", ":P", ":))", "B)", "<3", ":(",":'(" , ";)",":o");
    $img = array("<img src='emo/1.png' height='25' width='25' alt='happy' />",
    "<img src='emo/2.png' height='25' width='25' />",
    "<img src='emo/3.png' height='25' width='25' />",
    "<img src='emo/4.png' height='25' width='25' />",
	"<img src='emo/5.png' height='25' width='25' />",
	"<img src='emo/6.png' height='25' width='25' />",
	"<img src='emo/7.png' height='25' width='25' />",
	"<img src='emo/8.png' height='25' width='25' />",
	"<img src='emo/9.png' height='25' width='25' />",
	"<img src='emo/10.png' height='25' width='25' />"
	);
	
	$query_string = "";
	
	
	try {
		$dbconn = new PDO("mysql:dbname=chatserver;host=localhost","root", "");
		$dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		if($_SESSION['private'] == 'no'){
			
			if($_SESSION['public'] == 'p'){
			
				/* if $_SESSION['public'] is 'p' show all messages from chat_history table */
			
				$query_string = "select user_id, message, time from chat_history";
			}
			else{
				
				/* if $_SESSION['public'] is 'f' show only friend's messages from chat_history table */
			
				$query_string = "select * from chat_history where user_id in (SELECT rec_user FROM `friend_list` where req_user = '$urname')
				or user_id in (SELECT req_user FROM `friend_list` where rec_user = '$urname') or user_id = '$urname';";	
				
				//echo $query_string;
			}
			
			$result1 = $dbconn->query($query_string);/* execute query */
			$history = "";
		
			foreach($result1 as $row) {
			
			$mssg1 = "<i>(" . $row["time"]."):  "."</i>" ."<b>". $row["user_id"]."</b>";
			$mssg2 = ": " .$row["message"].  "<br>";
			
			$newstr1 = str_replace($urname, 'Me', $mssg1); /* replace username with  Me */
			$newstr2 = str_replace($emo, $img, $mssg2);/* replace emoticon characters with images */
			
			$history .= $newstr1; 
			$history .= $newstr2; 

       
			}
		}
		else{
			$frndname = $_SESSION['friend2'];
			$query_string = "select friend_one, friend_two, message, time from private_chat where
				(friend_one = '$urname' and friend_two = '$frndname') or (friend_one = '$frndname' and friend_two = '$urname')";
			
			$result1 = $dbconn->query($query_string);/* execute query */
			$history = "";
		
			foreach($result1 as $row) {
			
				$mssg1 = "<i>(" . $row["time"]."):  "."</i>" ."<b>". $row["friend_one"]."</b>";
				$mssg2 = ": " .$row["message"].  "<br>";
			
				$newstr1 = str_replace($urname, 'Me', $mssg1); /* replace username with  Me */
				$newstr2 = str_replace($emo, $img, $mssg2);/* replace emoticon characters with images */
			
				$history .= $newstr1; 
				$history .= $newstr2; 
			
			}	
		
		}
		echo $history;
	} catch  (PDOException $e) {
    	print_r($e->getMessage());    		
    	die();
	}	
		
	
?>