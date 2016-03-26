<?php
/********************************/
/* Course : COEN 276, Web Programming
/* Final Project, Chat Server
/* Name: Marufa Rahmi
/* Std id: w1128039*/


session_start();

/* This php file accepts or ignores friend request  */

$urname = $_SESSION['name'];
$frndrequest = "";
$count;
$i;
	
	
	if(isset($_GET['recfriend'])) {	
		
		$requser = $_GET['recfriend'];
		
		try {
			$dbconn = new PDO("mysql:dbname=chatserver;host=localhost",	"root", "");
			$dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			/* delete request from friend_request table  */
			$query_string = "DELETE FROM friend_request where req_user = '$requser' and rec_user = '$urname'";
			//echo $query_string;
			$dbconn->query($query_string);
			
			
			if($_GET['type'] == 'accept'){
				
				/* if accept button pressed save the friend connection in the friend_list table */
				$query_string = "INSERT INTO friend_list VALUES ('$requser' , '$urname')";
				//echo $query_string;
				$dbconn->query($query_string);
				
				echo '<script language="javascript">';				
				echo 'alert("Congratulations!! You are now friends.")';
				echo '</script>';
			}			

		} catch  (PDOException $e) {
			$error = 1;
			echo '<script language="javascript">';
			echo 'alert("You are already friends.")';
			echo '</script>';
			die();
			
		}			
	}	
	
	try {
		$dbconn = new PDO("mysql:dbname=chatserver;host=localhost",	"root", "");
		$dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			/* search database for friends request in friend_request table */
			$query_string = "SELECT req_user FROM friend_request WHERE  rec_user = '$urname'";
			
			
			$rows = $dbconn->query($query_string);
			
			
			$i = 0;
			$result = "";
			
			$count = $rows->rowCount(); /* count requests */
			if($count > 0) $result = "<p><h4>You have ".$count." friend request.<h4></p>";
			$result .= "<table width = '400px' align='center'>";
			foreach($rows as $row) {
				
				$_SESSION['req'][$i] = $row['req_user']; /* save the requesting user in session variable */
				
				$result .= '<tr><td>'.$row['req_user'].'</td>';
				$result .= '<td><a class="button" name="accept" href="friend_request.php?recfriend='.$row['req_user'].'&type=accept">Accept</a></td>';
				$result .= '<td><a class="button" name="ignor" href="friend_request.php?recfriend='.$row['req_user'].'&type=ignor">Ignor</a></td>';
				
				$i++;
			}
			$result .= "</table>";
			if($i == 0){
				$result = "<p><br/>There is no friend request available</p>";
			}
			$_SESSION['result'] = $result; /* saving result in the session variable*/
			

	} catch  (PDOException $e) {
		print_r($e->getMessage());
		
		die();
	}
	
	if(!empty($_SESSION['result'])) {
	$frndrequest = $_SESSION['result'];
	}

?>


<!DOCTYPE html>
<html>
	<head>
		<title>Chat Server</title>
		<link type="text/css" rel="stylesheet" href="style.css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
		<script type="text/javascript" src="../../scripts/jquery-1.11.1.min.js"></script>
		
		
	</head>
	
	<body>
		<br/>
		
		<div id = "frndrequstdiv">
		
			<div id="menu">
			<p class="welcome">Welcome, <b><?php echo $_SESSION['name']; ?></b></p>
			<p class="logout"><a id="exit" href="chatwindow.php">Go Back</a></p>
			<div style="clear:both">
			</div>
			
			<form name="myform" >
				<fieldset>
				
				<legend>Accept Friend Request</legend>
				<p id = "showreq"><?php echo $frndrequest?></p>
				
				</fieldset>
			</form>
			
		</div>		
	</body>
	
	
</html>