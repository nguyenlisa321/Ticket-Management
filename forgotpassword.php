<?php
  //FETCH INFORMATION
	if(isset($_POST["userid"])){
		$db = new mysqli('localhost', 'root', '', 'assignment3');
      if ($db->connect_error):
         die ("Could not connect to db: " . $db->connect_error);
      endif;
      $userid = $_POST["userid"];
      $email = $_POST["email"];
      $query = "SELECT Email FROM User WHERE Id='". $userid ."'and Email='". $email ."'";
      //echo $query;
      $results = $db->query($query) or die ("Invalid Select " . $db->error);
	  $data = $results->fetch_array();
  if($results->num_rows > 0){
      			$mailpath = '/Applications/XAMPP/xamppfiles/PHPMailer';
  $path = get_include_path();
  set_include_path($path . PATH_SEPARATOR . $mailpath);
  require 'PHPMailerAutoload.php';
  //MAILL NEW LINK
  $mail = new PHPMailer();
 
  $mail->IsSMTP(); // telling the class to use SMTP
  $mail->SMTPAuth = true; // enable SMTP authentication
  $mail->SMTPSecure = "tls"; // sets tls authentication
  $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server; or your email service
  $mail->Port = 587; // set the SMTP port for GMAIL server; or your email server port
  $mail->Username = "nguyenlisa321@gmail.com"; // email username
  $mail->Password = "targui$23"; // email password
   //$sender = strip_tags($_POST["sender"]);
  
  $receiver = strip_tags($_POST["email"]);

  // Put information into the message
  $resetid = uniqid();
  $mail->addAddress($receiver);
  $mail->SetFrom("nguyenlisa321@gmail.com");
  $mail->Subject = "Reset Password";
  $mail->Body = "Reset Link: http://localhost/assignment3/resetpassword.php?resetid=" . $resetid;

  if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
   } 
   else { echo 'Reset Link has been sent'; }
  $query = "UPDATE User SET Password='" . $resetid . "' WHERE Id='" . $userid . "'";
  $results = $db->query($query) or die ("Invalid Update " . $db->error);
      		}


    //ACOUNT NOT FOUND IN DATABASE
    else {
    	echo "Account not found";
    	    }
	}

?>
