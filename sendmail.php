<!DOCTYPE html>
<html>
<head>
<title>Send Mail Results</title>
</head>
<body>
<?php
  require_once('class.ticket.php');
  
  $mailpath = '/Applications/XAMPP/xamppfiles/PHPMailer';
  session_start();
  
  // Also note that Windows installations have different path names - be sure
  // to follow the syntax correctly.
  // Also, on my Windows version, to get this to work I had to do the following:
  // 	Edit file 'php.ini'  (you need to find where that is)
  //	Locate the line:  extension=php_openssl.dll
  //	If there is a semicolon (;) at the beginning of the line, delete it
  //	Save the file
  //	Start / restart Apache
  
  
  // Add the new path items to the previous PHP path
  $path = get_include_path();
  set_include_path($path . PATH_SEPARATOR . $mailpath);
  require 'PHPMailerAutoload.php';
  
  // PHPMailer is a class -- we will discuss classes and PHP object-oriented
  // programming soon.  However, you should be able to copy / use this
  // technique without fully understanding PHP OOP.
  $mail = new PHPMailer();
 
  $mail->IsSMTP(); // telling the class to use SMTP
  $mail->SMTPAuth = true; // enable SMTP authentication
  $mail->SMTPSecure = "tls"; // sets tls authentication
  $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server; or your email service
  $mail->Port = 587; // set the SMTP port for GMAIL server; or your email server port
  $mail->Username = "nguyenlisa321@gmail.com"; // email username
  $mail->Password = "targui$23"; // email password
  //$mail->Username = "cs4501.fall15@gmail.com"; // email username
  //$mail->Password = "UVACSROCKS"; // email password

  //$sender = strip_tags($_POST["sender"]);
  $receiver = $_POST["Email"];
  echo $receiver;
  $subj = strip_tags($_POST["Subject"]);
  $msg = strip_tags($_POST["Description"]);
  $receiver = strip_tags($_POST["Email"]);
  $fname = strip_tags($_POST["First_name"]);
  $lname = strip_tags($_POST["Last_name"]);
  $received = date('Y-m-d H:i:s');
  //Make ticket
  $ticket = new Ticket($received, $fname, $lname, $receiver, $subj, $msg, NULL);
  $ticket->input_db();
  $id = $ticket->get_id();
  $ticket->input_admin($id);
  // Put information into the message
  $mail->addAddress($receiver);
  $mail->SetFrom("nguyenlisa321@gmail.com");
  $mail->Subject = "$subj";
  $mail->Body = "Issue: $msg". "\n\n Your ticket has been sent and will be handled promptly";

  // echo 'Everything ok so far' . var_dump($mail);
  if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
   } 
   else { echo 'Message has been sent'; }

  $mail->ClearAllRecipients( ); 
  $db = new mysqli('localhost', 'root', '', 'assignment3');
      if ($db->connect_error):
         die ("Could not connect to db: " . $db->connect_error);
      endif;
  $query = "SELECT Email FROM User WHERE Type = 'admin'";
  $results = $db->query($query) or die ("Invalid select " . $db->error);
  $rows = $results->num_rows;
 
  for ($i = 0; $i < $rows; $i++) {
    $data = $results->fetch_array();
    $receiver = $data['Email'];
    $mail->addAddress("$receiver");
  }
  
  $mail->SetFrom("nguyenlisa321@gmail.com");
  $mail->Subject = "$subj";
  $mail->Body = "Ticket sent by $fname $lname \n Issue: $msg";

  // echo 'Everything ok so far' . var_dump($mail);
  if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
   } 
   //else { echo 'Message has been sent'; }
   
?>
<br /><br />
<a href="submit.php"> Submit Again</a> or <a href="login.php?logout=true"> Logout </a>
</body>
</html>
