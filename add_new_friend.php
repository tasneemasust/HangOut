<?php

/********************************/
/* Course : COEN 276, Web Programming
/* Final Project, Chat Server
/* Name: Marufa Rahmi
/* Std id: w1128039*/


session_start(); 

/* This php file send friend requests using user name */
/* there is a search option to search for friend by name */

$errorMessage = $sendrequest = $frndname = "";
$output_message = "";
$urname = $_SESSION['name'];
$error = 0;
$_SESSION['result'] = "";


if($_GET) {
	try {
		$dbconn = new PDO("mysql:dbname=chatserver;host=localhost", "root", "");
	    $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
		if(isset($_GET['searchfrnd'])) {
			
			/* search user table for partial match */
			$query_string = "SELECT * FROM user WHERE (last_name like '{$_GET['frndname']}%' OR first_name like '{$_GET['frndname']}%')";
		}
				
		$rows = $dbconn->query($query_string);	/* execute query */
		
            
            $i = 0;
			foreach($rows as $row) {
				$_SESSION['result'] .= $row['first_name'].' '.$row['last_name'].' -> User Name: '.$row['user_id']."\n";		
				$i++;
			}
	
	} catch  (PDOException $e) {
    		print_r($e->getMessage());
    		
    		die();
	}
}

if($_POST) {
	$sendrequest =  $_POST['sendrequest'];
	
	
	if(!$error) {
		// if there no error, do database here
	
		$mysqli = new mysqli('localhost',
				'root',
				'',
				'chatserver');

		if ($mysqli->connect_error) {
			die('Connect Error (' . $mysqli->connect_errno . ') '
					. $mysqli->connect_error);
		}
	
		$_SESSION['addfrnd']['outmessage'] = 'Success... ' . $mysqli->host_info . "\n";
		
		/* insert request in to friend_request table*/
		
		$mysqli->query("INSERT INTO friend_request VALUES ('$urname','$sendrequest')");		
		$mysqli->close(); 
		
		echo '<script language="javascript">';
		echo 'alert("Request send successfully!")';
		echo '</script>';
    
		//header("Location:". $_SERVER['PHP_SELF'], true, 303);
		//exit();
		
	}
	else // if error, then create session info, and redirect 
	{	   
		echo '<script language="javascript">';
		echo 'alert("Error! Try again")';
		echo '</script>';
   		header("Location:". $_SERVER['PHP_SELF'], true, 303);
   		exit();
	}
	
} 


if(!empty($_SESSION['result'])) {
	$output_message = $_SESSION['result'];
}	
?>


<!DOCTYPE html>
<html>
	<head>
		<title>Chat Server</title>
		<link type="text/css" rel="stylesheet" href="style.css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
	</head>
	<body>
	
	<div id="request">
		<div id="menu">
			<p class="welcome">Welcome, <b><?php echo $_SESSION['name']; ?></b></p>
			<p class="logout"><a id="exit" href="chatwindow.php">Go Back</a></p>
			<div style="clear:both">
		</div>
	<br/>
	<p><b>Type the username and send request</p>
	</br>
		<div id = "searchfrnddiv" >
			<form name="myform" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
				<fieldset>
				<legend>Send Friend Request</legend>
				<input type="text" id="sendrequest" name="sendrequest" value="<?= $sendrequest?>" placeholder="Type user name">
				<span id="errorclass"><?=$errorMessage; ?></span>
				<input type="submit" name="requestbutton" value="Send Request">
				</fieldset>
			</form>
			<br/><br/>
			<br/>
			<p><b>Search your friend's username.</p>
			</br>
			<form name="searchform" action="<?php echo $_SERVER['PHP_SELF']?>" method="get">		
					<fieldset>
					<legend>Search Friend</legend>
						Name: <input type="text" id="searchfrnd" name="frndname" value="<?= $frndname?>" placeholder="Enter name">
						
						<input type="submit" name="searchfrnd" value="search">
					</fieldset>

					<fieldset>
					<legend>Suggestion</legend>						
						 <textarea name="output" id="suggestions" rows='10' cols='50'><?=$output_message?></textarea>
					</fieldset>
			</form>

		</div>
	</div>	
	<script>
		
		
		document.addEventListener('DOMContentLoaded', function(){
			document.getElementById('searchfrnd').addEventListener('keyup', function(){displaySuggestion(this.value)});

		});

		
		function displaySuggestion(searchChars) {
			var ajx = new XMLHttpRequest();
			//alert(searchChars);
			ajx.open('GET', 'searchIt.php?n_friend='+searchChars, true);
			ajx.onreadystatechange = function() 
			{
				if(ajx.readyState==4) {
					if(ajx.status ==200) {
						document.getElementById('suggestions').innerHTML = ajx.responseText;
					}
				}
			};
			ajx.send(null);
		}
</script>
	</body>
</html>