<?php

/********************************/
/* Course : COEN 276, Web Programming
/* Final Project, Chat Server
/* Name: Marufa Rahmi
/* Std id: w1128039*/


session_start();

/* Variable declaration*/
$error = 0;

$fname = $lname = $uname = "";
$email = $password = $repassword = "";
$address = "";
$output_message = "";

$errormsg= "";
$errorMessage1 = "";
$errorMessage2 = "";
$errorMessage3 = "";
$errorMessage4 = "";
$errorMessage5 = "";
$errorMessage6 = "";
$errorMessage7 = "";

echo "<br>--------------------POST-----------------------------------<br>";
echo "<pre>";
var_dump($_POST);
echo "</pre>";
echo "<br>--------------------GET------------------------------------<br>";
echo "<pre>";
var_dump($_GET);
echo "</pre>";
echo "<br>-----------------------------------------------------------<br>";

echo "<br>--------------------SESSION------------------------------------<br>";
echo "<pre>";
var_dump($_SESSION);
echo "</pre>";
echo "<br>-----------------------------------------------------------<br>";
echo "error is ".$error;



if(isset($_POST['submit'])) {
	
	$address = $_POST['address'];;

	/* if first name is empty set errorMessage1 */
	if($_POST['fname'] != ""){
		$fname =  $_POST['fname'];
		$errorMessage1 = "";
	}
	else{
		$error = 1;
		$errorMessage1 = "Enter your First name";
	}
	
	/* if last name is empty set errorMessage2 */
	if($_POST['lname'] != ""){
		$lname = $_POST['lname'];
		$errorMessage2 = "";
	}
	else{
		$error = 1;
		$errorMessage2 = "Enter your Last name";
	}
	
	/* if email is empty set errorMessage3 */
	if($_POST['email'] != ""){
		$email = $_POST['email'];
		$errorMessage3 = "";
	}
	else{
		$error = 1;
		$errorMessage3 = "Enter your email";
	}
	
	/* if user name is empty set errorMessage4 */
	if($_POST['uname'] != ""){
		$uname = $_POST['uname'];
		$errorMessage5 = "";
	}
	else{
		$error = 1;
		$errorMessage5 = "Enter your User name";
	}
	
	/* if password is empty set errorMessage6 */
	if($_POST['password'] != ""){
		$password = $_POST['password'];
		$errorMessage6 = "";
	}
	else{
		$error = 1;
		$errorMessage6 = "Enter your Password";
	}
	
	/* if password re entry is empty set errorMessage7 */
	if($_POST['repassword'] != ""){
		$password = $_POST['repassword'];
		$errorMessage7 = "";
	}
	else{
		$error = 1;
		$errorMessage7 = "Enter your Password again";
	}
	
	/* if passwords do not match set errorMessage7 "Passwords does not matched, please enter again" */
	if($_POST['repassword'] != $_POST['password']){		
		$error = 1;
		$errorMessage7 = "Passwords does not matched, please enter again";
	}
	
	
	
	if(!$error) {
		/* if there no error, insert information into the database*/
		$error = 1;
		try {
			$dbconn = new PDO("mysql:dbname=chatserver;host=localhost","root", "");
			$dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			$query_string = "INSERT INTO user(user_id, first_name, last_name, Address, email, password) VALUES ('$uname', '$fname', '$lname', '$address', '$email', '$password')";	
		
			$dbconn->query($query_string);	/* execute query */

			$error = 0;
	
		} catch  (PDOException $e) {
			/* show alert for existing user	*/	
			
    		echo '<script language="javascript">';
			echo 'alert("User name is not available, try another one.")';
			echo '</script>';
			$errormsg = "User name is not available, try another one.";
			//print_r($e->getMessage());
			die();    		
		}
		
		//header("Location:". $_SERVER['PHP_SELF'], true, 303);
		//exit();		
	}
} 


?>



<!DOCTYPE html>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="style.css" />
		<style>			
			#errorclass {
				color:red;
			}
		</style>
	</head>
<body>

<?php
	if(isset($_POST['submit']) && $error == 0 ){
		echo '
		<div id="successform">
		<p> Congratulations! You are successfully added to the database.</p>
		<a href="index.php">Log in</a>
		</div>';
		
	}
	
	else{
		//$error = 0;
?>
	<div id="newuserform">	
	<div id="menu">			
			<p class="logout"><a id="exit" href="index.php">Go Back</a></p>
	</div>		
	<p><?php echo $errormsg; ?></p>
	<form  action="add_new_user.php?$error=1" method="post">
		<fieldset>
		<legend>Fill Up the form</legend>
		<table align="center">
		<tr>
			<td align="left">First Name: </td><td align="left"><input type="text" name="fname" value="<?= $fname?>" placeholder="Enter first name"></td>
			<td align="left"><span id="errorclass"><?=$errorMessage1; ?></span></td>
		</tr><tr>
			<td align="left">Last Name: </td><td align="left"><input type="text" name="lname" value="<?= $lname?>" placeholder="Enter last name"></td>
			<td align="left"><span id="errorclass"><?=$errorMessage2; ?></span></td>
		</tr><tr>
			<td align="left">email: </td><td align="left"><input type="text" name="email" value="<?= $email?>" placeholder="Enter your email"></td>
			<td align="left"><span id="errorclass"><?=$errorMessage3; ?></span></td>
		</tr><tr>
			<td align="left">Address:  </td><td align="left"><input type="text" name="address" value="<?= $address?>" placeholder="Enter address"></td>
			<td align="left"><span id="errorclass"><?=$errorMessage4; ?></span></td>
		</tr><tr>
			<td align="left">User name:  </td><td align="left"><input type="text" name="uname" value="<?= $uname?>" placeholder="Enter User name"></td>
			<td align="left"><span id="errorclass"><?=$errorMessage5; ?></span></td>
		</tr><tr>
			<td align="left">Password:  </td><td align="left"><input type="password" name="password" value="<?= $password?>" placeholder="Enter password"></td>
			<td align="left"><span id="errorclass"><?=$errorMessage6; ?></span></td>
		</tr><tr>
			<td align="left">Re-type Password:  </td><td align="left"><input type="password" name="repassword" value="<?= $repassword?>" placeholder="Re-enter your password"></td>
			<td align="left"><span id="errorclass"><?=$errorMessage7; ?></span></td>
		</tr>
		</table>
		<input type="submit" name="submit" value="Submit"><br/><br/>
		</fieldset>
	</form>
	</div>
<?php
	}
?>

</html>