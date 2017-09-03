<?php
session_start();
$userid = $_SESSION['userid'];
if(isset($_POST['ticket'])){
$_SESSION['ticket'] =  $_POST['ticket'];
}
$id = $_SESSION['ticket'];
?>


<?php

    $db = new mysqli('localhost', 'root', '', 'assignment2');
        if ($db->connect_error):
        die ("Could not connect to db: " . $db->connect_error);
        endif;

        $mailpath = '/Applications/XAMPP/xamppfiles/PHPMailer';

      $path = get_include_path();
      set_include_path($path . PATH_SEPARATOR . $mailpath);
      require 'PHPMailerAutoload.php';

      $mail = new PHPMailer();
 
      $mail->IsSMTP(); // telling the class to use SMTP
      $mail->SMTPAuth = true; // enable SMTP authentication
      $mail->SMTPSecure = "tls"; // sets tls authentication
      $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server; or your email service
      $mail->Port = 587; // set the SMTP port for GMAIL server; or your email server port
      $mail->Username = "nguyenlisa321@gmail.com"; // email username
      $mail->Password = "targui$23"; // email password

  


      $receiver = strip_tags($_POST['receiver']);
      //echo $receiver;
      $subj = strip_tags($_POST['subject']);
      //echo $subj;
      $msg = strip_tags($_POST["message"]);
      //echo $msg;
      $mail->addAddress($receiver);
      $mail->SetFrom("nguyenlisa321@gmail.com");
      $mail->Subject = "$subj";
      $mail->Body = "$msg";

      if(!$mail->send()) {
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
       } 
     
      else { echo 'Message has been sent'; 
      }
   ?>