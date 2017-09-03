<?php
session_start();
if(!isset($_SESSION["login"])){
  header("Location: login.php");
  exit;
}
  ?>
<!DOCTYPE html>
<html>
<head>
    <title>Send A Support Request</title>
</head>
<body>
    <h3>Create a Ticket</h3>
    <form action = "sendmail.php"
          method = "POST">

    <b>First Name</b>
    <input type = "text" name = "First_name" size = "30" maxlength = "30" required="">
    <br /><br />
    <b>Last Name</b>
    <input type = "text" name = "Last_name" size = "30" maxlength = "30" required="">
    <br /><br />
    <b>Email</b>
     <input type = "email" name = "Email" size = "30" maxlength = "30" required="">
    <br /><br />
    <b>Subject?</b>
    <input type = "text" name = "Subject" size = "60" maxlength = "60" required="">
    <br /><br />
    <b>Please type your description below:</b><br />
    <br />
    <textarea name="Description" rows="5" cols="60" required=""></textarea>
    <br /><br />
    <input type = "submit" value = "Submit">
    </form>
    <a href="login.php?logout=true"> Logout </a>
</body>
</html>