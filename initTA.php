<!DOCTYPE html>
<html>
 <head>
  <title>MySQL Setup Example</title>
 </head>
 <body>
 <?php
      $db = new mysqli('localhost', 'root', '', 'assignment3');
      if ($db->connect_error):
         die ("Could not connect to db: " . $db->connect_error);
      endif;
      $db->query("drop table User");
      $db->query("drop table Ticket"); 
      $db->query("drop table Ticket_Admin");
      //INITIALIZE THE USER, TICKET, TICKET_ADMIN TABLE 
      $result = $db->query(
                "create table User (User_id int primary key not null auto_increment , Id varchar(30) not null,  First_name  char(30) not null, Last_name char(30), Password varchar(50) not null, Email char(50) not null, Type char(30) not null)") or die ("Invalid: " . $db->error);
      $result = $db->query(
      			"create table Ticket (Ticket_id int primary key not null auto_increment, Sender_first_name char(30) not null, Sender_last_name char(30) not null, Received Datetime not null, Email text not null, Subject text not null, Description text not null, Status varchar(300) not null )") or die
      			("Invalid: " . $db->error); 
      $result = $db->query(
      			"create table Ticket_Admin (Ticket_id int not null, User_id int )") or die
      			("Invalid: " . $db->error);
       $query = "INSERT INTO `User` (`User_id`, `Id`, `First_name`, `Last_name`, `Password`, `Email`, `Type`) VALUES (NULL, '', '', NULL, '', '', '')";
          $results = $db->query($query) or die ("Invalid insert " . $db->error); 
      //POPULATE USERS
      $user = file("user2.flat");
      foreach ($user as $userstring)
      {
          $usertring = rtrim($userstring);
          $user  = preg_split("/ +/", $userstring);
          $password = hash("md5", $user[3]);

          $query = "INSERT INTO User VALUES (NULL,'$user[0]', '$user[1]', '$user[2]', '$password', '$user[4]', '$user[5]')";
          $results = $db->query($query) or die ("Invalid insert " . $db->error);
      } 
      //POPULATE TICKETS
      $ticket = file("ticket2.flat");
      foreach ($ticket as $ticketstring)
      {
          $ticketstring = rtrim($ticketstring);
          $ticket  = preg_split("/#+/", $ticketstring);
          //print_r($ticket);
          //$password = hash("md5", $user[3]);
          $query = "INSERT INTO Ticket VALUES ('$ticket[0]','$ticket[2]', '$ticket[3]', '$ticket[1]', '$ticket[4]', '$ticket[5]', '$ticket[6]', '$ticket[7]')";
          $results = $db->query($query) or die ("Invalid insert " . $db->error);
      } 
      //POPULATE TICKET_ADMIN
      $admin = file("ticket_admin.flat");
      foreach ($admin as $adminstring)
      {
          $adminstring = rtrim($adminstring);
          $admin  = preg_split("/ +/", $adminstring);
          //print_r($ticket);
          //$password = hash("md5", $user[3]);
          $query = "INSERT INTO Ticket_Admin VALUES ($admin[0], $admin[1])";
          //echo $query;
          $results = $db->query($query) or die ("Invalid insert " . $db->error);
      } 
     
      
?>
 </body>
</html>