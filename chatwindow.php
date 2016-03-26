<?php
/********************************/
/* Course : COEN 276, Web Programming
/* Final Project, Chat Server
/* Name: Marufa Rahmi
/* Std id: w1128039*/


session_start();

	/* Variable declaration*/
	$name = "";
	$password = "";
	$error = 0;
	$output_message = "";
	$frndname = "";
	$errorMessage = "";
	$availableonline = "";
	$loginflag = 0;
	$urname = $_SESSION['name'];
	$cur_chat = "";
	$unreadmssg = "";
	
	/* $_GET['public'] is set to decide which view a user want to see*/
	/* if 'p' is set, user will see all chat messages */
	/* if 'f' is set user will see only friend's messages */
	/* 'p' is set as default */
	
	if(!isset($_GET['public']))$_SESSION['public']= 'p';
	else $_SESSION['public'] = $_GET['public'];
	
	
	/* $_GET['private'] is set to decide whether user want to do a private chat or not */
	/* if 'no' is set, user will see public chat messages and users message will be available to all*/
	/* if 'yes' is set user will see only one friend's messages and this friend will see users message */
	/* 'no' is set as default */
	
	if(!isset($_GET['private'])){
		$_SESSION['private']= 'no';
		
	}
	else{
		$_SESSION['private'] = $_GET['private'];
		if(isset($_GET['friendname'])){
			$_SESSION['friend2'] = $_GET['friendname'];
		}
	}
	
	if($_SESSION['private'] == 'yes'){
		$cur_chat = $_SESSION['friend2'];
	}
	else{
		$cur_chat = "everybody";
	}
		
		
	/* When a user log out, keep record in the chat_history table and destroy session*/
	/* Also delete this user from available_online table */
	
	if(isset($_GET['logout'])){
	
		
		$msg = " left the chat session.";	
		$date = date("Y-m-d H:i:s");	
		
		try {
			$dbconn = new PDO("mysql:dbname=chatserver;host=localhost","root", "");
			$dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			$query_string = "INSERT INTO chat_history(user_id, message,time) VALUES ('$urname', '$msg','$date')";		
			$dbconn->query($query_string);
			
			$query_string = "DELETE FROM available_user WHERE user_id = '$urname'";		
			$dbconn->query($query_string);
		
	
		} catch  (PDOException $e) {
    		print_r($e->getMessage());
    		
    		die();
		}		
		
		session_destroy();
		header("Location: index.php"); //Redirect the user
		
	}
	
	
	/************************************************************************************************************/
	/************************************* find any unread message *****************************************************/
		try {
					
			$dbconn = new PDO("mysql:dbname=chatserver;host=localhost","root", "");
			$dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			$query = "SELECT * FROM unread_chat";
			$res = $dbconn->query($query);
			//$flag = true;	
			
			foreach($res as $row) {
				if($row["friend_two"] == $urname){
					$frnd = $row["friend_one"];
					$unreadmssg = "You have message from ".$frnd;
					$query = "DELETE FROM unread_chat where friend_one = '$frnd' and friend_two = '$urname'";
					$res = $dbconn->query($query);
					break;
				}
			}
	
		} catch  (PDOException $e) {
			print_r($e->getMessage());    		
			die();
		}
	
	
	
	/************************************************************************************************************/
	/************************************* find friend list *****************************************************/
		try {
					
			$dbconn = new PDO("mysql:dbname=chatserver;host=localhost","root", "");
			$dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			$query_string = "(SELECT rec_user FROM `friend_list` WHERE req_user = '$urname') union (SELECT req_user FROM `friend_list` WHERE rec_user = '$urname') ";
			$result2 = $dbconn->query($query_string);
					
			$friendlist = "";
			$i = 0;
			foreach($result2 as $row) {
				$_SESSION['friend'][$i] = $row['rec_user'];
				$friendlist .= '<a  name="friend" href="chatwindow.php?friendname='.$_SESSION['friend'][$i].'&private=yes"><b>'.$row['rec_user'].'</b></a><br/>';	
				$i++;
			}
			
			$_SESSION['friendlist'] = $friendlist;
	
		} catch  (PDOException $e) {
			print_r($e->getMessage());    		
			die();
		}
	
	if (!isset($_SESSION['id'])) {
		$_GET['logout'] = true;
	}
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Chat Server</title>
		<link type="text/css" rel="stylesheet" href="style.css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
	</head>

	<div id="wrapper">		
		
		<div id = "onlinefrnd">
			<p align ="left" class="available"><h4>Friend List</h4></p>	
			<div id = "friendlist"> <?php echo $_SESSION['friendlist']; ?>	</div>
			<p align ="left" class="available"><h4>Available Online</h4><b></b></p>	
			<div id="userbox"></div>
			
			<div id="links">			
			<a class="button" name="publicchat" href="chatwindow.php?public=p&private=no">Public Chat</a><br/>
			<a class="button" name="frndchat" href="chatwindow.php?public=f&private=no">Only Friends</a><br/>
			<a class="button" href="add_new_friend.php" >Add New Friend</a><br/>
			<a class="button" href="friend_request.php" >Friend Requests</a>
			</div>	
		</div>
		
		<div id = "right">
		<div id="menu">
			<p class="welcome"><h3>Welcome, <b><?php echo $_SESSION['name']; ?></b><h3></p>
			<p class="logout"><a id="exit" href="#">Exit Chat</a></p>
		</div>	
		<p>You are talking to <b><?php echo $cur_chat; ?></b></p>
		<span><i><?php echo $unreadmssg; ?> </i></span>
		<div id="chatbox"></div>
		<div id = "insertmsg">
		<form name="message" action="">
			<input name="usermsg" type="text" id="usermsg" size="63" />
			<input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
		</form>
		</div>
		</div>
		
		

	</div>
	
	
	
	
	<script type="text/javascript">
	
	

	$(document).ready(function(){
		
		/* when exit chat clicked, the following function set logout=true*/
		$("#exit").click(function(){
			var exit = confirm("Are you sure you want to end the session?");
			if(exit==true){window.location = 'chatwindow.php?logout=true';}
		});

		
		/* when send button is clicked or enter pressed after writing*/
		/* the following function call post.php, which saves the new message in to chat_history table in the database */
		
		$("#submitmsg").click(function(){
			var clientmsg = $("#usermsg").val();
			$.post("post.php", {text: clientmsg});
			$("#usermsg").attr("value", "");
			return false;
		});
		
		
		setInterval (loadLog, 1500);
		setInterval (loaduser, 3000);
		
		/* This is a ajax function*/
		/* called every 1.5sec to refresh chatbox*/
		function loadLog(){
			var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
			
			$.ajax({url: "retrieve.php",
				cache: false,				
				success: function(){					
					$('#chatbox').load('retrieve.php',function () {

						/* scroll setting*/
						var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
						if(newscrollHeight > oldscrollHeight){
							$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); 
						}
					});					
				},
			});
		}
		
		
		/* This is a ajax function*/
		/* called every 1.5sec to refresh available user*/
		function loaduser(){
			var oldscrollHeight = $("#userbox").attr("scrollHeight") - 20;
			
			$.ajax({url: "available_online.php",
				cache: false,				
				success: function(){					
					$('#userbox').load('available_online.php',function () {
						
						/* scroll setting*/
						var newscrollHeight = $("#userbox").attr("scrollHeight") - 20;
						if(newscrollHeight > oldscrollHeight){
							$("#userbox").animate({ scrollTop: newscrollHeight }, 'normal'); 
						}
					});					
				},
			});
		}
	});
	</script>

	</body>
</html>
