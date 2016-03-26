<?php
session_start();
/********************************/
/* Course : COEN 276, Web Programming
/* Final Project, Chat Server
/* Name: Marufa Rahmi
/* Std id: w1128039*/


	/* Variable declaration*/
	$name = "";
	$password = "";
	$error = 0;
	$output_message = "";
	$errorMessage = "";
	
	
	if(isset($_POST['enter'])){
		
		if($_POST['name'] != "" && $_POST['password'] != ""){
			
			
			/* take $_SESSION['name'] and $_SESSION['password'] from the input field. */
			/* stripslashes(htmlspecialchars()) erase the unnecessary spaces */
			
			$_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
			$_SESSION['password'] = stripslashes(htmlspecialchars($_POST['password']));
			$name = $_POST['name'];
			$password = $_SESSION['password'];
			$date = date("Y-m-d H:i:s");
			
			
			/* check database, if the id, password are correct */
			try {
				$dbconn = new PDO("mysql:dbname=chatserver;host=localhost","root", "");
				$dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
				$query_string = "SELECT * FROM user WHERE user_id = '$name' AND password = '$password' ";				
				
				$res = $dbconn->query($query_string);
				$i = 0;
				
				foreach($res as $row) {
					$i++;
				}
				
				/* If there is no match in the database for id password*/
				/* Show the error message */
				if($i == 0){
					
					echo '<span class="error">Incorrect User name or password</span>';
					$_POST['name'] = "";
					$_POST['password'] != "";
					$error = 1;
				}
				else {
					/* For valid id, password check if this user is already logged in to another browser */
					/* If every ok, insert this user information in to available user table */
					/* everyone can see who is available online */
					$error = 0;				
					
					try {
						
						$dbconn = new PDO("mysql:dbname=chatserver;host=localhost","root", "");
						$dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						
						$query_string = "INSERT INTO available_user(user_id, time) VALUES ('$name', '$date')";					
						$dbconn->query($query_string);
						
						header("Location: chatwindow.php");
					}
					 catch  (PDOException $e) {
						/* if this id, password in already available_online table show alert*/
						$error = 1;
						echo '<script language="javascript">';
						echo 'alert("Already Logged in another browser. Try as a different user")';
						echo '</script>';
					}				
				}
	
			} catch  (PDOException $e) {
				/* if id, password is incorrect show alert*/
				$error = 1;
				echo '<script language="javascript">';
				echo 'alert("Please try again")';
				echo '</script>';
				die();
			}			
		}
		else{
			/* if username or password field empty show this message*/
			echo '<span class="error">Please type your user id and password</span>';
		}
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
		<div id="loginform">
		<form action="index.php" method="post">
			<p>Please enter your user name and password to continue:</p><br/>
			<label for="name">User name:</label>
			<input type="text" name="name" id="name" /><br/><br/>
			<label for="password">Password: </label>
			<input type="password" name="password"><br/><br/>
			<input type="submit" name="enter" id="enter" value="Enter" />			
			<p>If you are a new user, <a href="add_new_user.php">Register</a> here</p>

		</form>
		</div>';
	</body>
	
</html>