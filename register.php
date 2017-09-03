<?php
$db = new mysqli('localhost', 'root', '', 'assignment3');
      if ($db->connect_error):
         die ("Could not connect to db: " . $db->connect_error);
      endif;
$id = $_POST['id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = hash("md5", $_POST['password']);

          $query = "INSERT INTO User VALUES (NULL,'$id', '$first_name', '$last_name', '$password', '$email', 'regular')";
          $results = $db->query($query) or die ("Invalid insert " . $db->error);
?>