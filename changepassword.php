<?php
session_start();
//CHANGE PASSWORD
if(isset($_POST['password'])):
$db = new mysqli('localhost', 'root', '', 'assignment3');
      if ($db->connect_error):
         die ("Could not connect to db: " . $db->connect_error);
      endif;
$password = hash("md5", $_POST["password"]);
$query = "UPDATE User SET Password='". $password. "' WHERE Id='" . $_POST['userid'] ."'";
$results = $db->query($query) or die ("Invalid Select " . $db->error);
if($results){ echo "Password Reset";
exit;
} else 
	echo "Pasword Failed to Reset";
	exit;

endif;