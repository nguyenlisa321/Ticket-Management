<?php
$return_arr = array();
$db = new mysqli('localhost', 'root', '', 'assignment3');
      	if ($db->connect_error):
        die ("Could not connect to db: " . $db->connect_error);
        endif;
        $query = "SELECT Ticket.*, User.First_name, User.Last_name FROM Ticket, Ticket_Admin, User WHERE Ticket.Ticket_id = Ticket_Admin.Ticket_id and Ticket_Admin.User_id= User.User_id "; #Define query
         	$result= $db->query($query) or die ("Invalid select " . $db->error);
         	 #Eval and store result
while ($row = $result->fetch_assoc()) {
	//echo var_dump($row);
	array_push($return_arr,$row);
}



echo json_encode($return_arr);

?>