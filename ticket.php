 <?php
$return_arr = array();
$db = new mysqli('localhost', 'root', '', 'assignment3');
        if ($db->connect_error):
        die ("Could not connect to db: " . $db->connect_error);
        endif;
 if (isset($_POST['status'])){
  $id = $_POST['id'];

        if($_POST['status'] == "open") {
                 $query = "UPDATE Ticket SET Ticket.Status = 'closed' WHERE Ticket.Ticket_id = $id";
          }
          else {
            $query = "UPDATE Ticket SET Ticket.Status = 'open' WHERE Ticket.Ticket_id = $id";
          }
          $results = $db->query($query) or die ("Invalid update " . $db->error);  #Eval and store result

      }
      else if (isset($_POST['assign'])){
        $id = $_POST['id'];
        $userid = $_POST['assign'];
        $query = "UPDATE Ticket_Admin, User SET Ticket_Admin.User_id = User.User_id WHERE Ticket_Admin.Ticket_id = $id and User.Id = '$userid'";
        $results = $db->query($query) or die ("Invalid select " . $db->error); 
      }
      else if (isset($_POST['remove'])){
        $id = $_POST['id'];
        $userid = $_POST['remove'];
        $query = "UPDATE Ticket_Admin, User SET Ticket_Admin.User_id = 1 WHERE Ticket_Admin.Ticket_id = $id and User.Id = '$userid'";
          $results = $db->query($query) or die ("Invalid update " . $db->error); 
      }
      else if (isset($_POST['delete'])){
        $id = $_POST['delete'];
        $query = "DELETE FROM Ticket WHERE Ticket.Ticket_id = $id";
        $results = $db->query($query) or die ("Invalid select " . $db->error);  #Eval and store result
        $rows = 0;
        $query = "DELETE FROM Ticket_Admin WHERE Ticket_Admin.Ticket_id = $id";
        $results = $db->query($query) or die ("Invalid select " . $db->error);
        
}      
$query = "SELECT Ticket.*, User.First_name, User.Last_name FROM Ticket, Ticket_Admin, User WHERE Ticket.Ticket_id = Ticket_Admin.Ticket_id and Ticket_Admin.User_id= User.User_id "; #Define query
          $result= $db->query($query) or die ("Invalid select " . $db->error);
           #Eval and store result
while ($row = $result->fetch_assoc()) {
  //echo var_dump($row);
  array_push($return_arr,$row);
}



echo json_encode($return_arr);
?>