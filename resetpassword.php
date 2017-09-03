<?php
session_start();
//CHANGE PASSWORD
if(isset($_POST['password'])):
$db = new mysqli('localhost', 'root', '', 'assignment3');
      if ($db->connect_error):
         die ("Could not connect to db: " . $db->connect_error);
      endif;
$password = hash("md5", $_POST["password"]);
$query = "UPDATE User SET Password='". $password. "' WHERE Id='" . $_SESSION['userid'] ."'";
$results = $db->query($query) or die ("Invalid Select " . $db->error);
if($results){ echo "Password Reset";
exit;
} else 
	echo "Pasword Failed to Reset";
	exit;

endif;
//GET USER FROM CERTAIN RESET ID
if(isset($_GET['resetid'])):
$db = new mysqli('localhost', 'root', '', 'assignment3');
      if ($db->connect_error):
         die ("Could not connect to db: " . $db->connect_error);
      endif;
$query = "SELECT Id from User WHERE Password='" . $_GET['resetid'] ."'";
$results = $db->query($query) or die ("Invalid Select " . $db->error);
$data = $results->fetch_array();
$_SESSION["userid"] = $data[0];
$userid= $data[0];
endif;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Reset Password</title>
   <link rel = "stylesheet" type = "text/css" href = "style.css"/>
</head>
<body>
<h3> Reset Password for <?php echo "$userid" ?> </h3>
<form action ="resetpassword.php"
	  method = "POST">
<b> Enter New Password: </b> <input type="text" name="password" required="">

	<input type="submit" value="Submit" id="submit">
</body>
</html>