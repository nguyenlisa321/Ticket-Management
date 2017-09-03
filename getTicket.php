<?php
session_start();
$userid = $_SESSION["userid"];
$db = new mysqli('localhost', 'root', '', 'assignment3');

if ($db->connect_error) {
	die ( "Could not connect to db" . $db->connect_error );
}

$return_arr = array();

$result = $db->query("SELECT Ticket.Ticket_Id, Ticket.Received, Ticket.Subject, Ticket.Status FROM Ticket, User WHERE User.Id = '$userid' AND Ticket.Sender_first_name = User.First_name and Ticket.Sender_Last_name = User.Last_name") or die ("Invalid Select " . $db->error);;



while ($row = $result->fetch_assoc()) {
	array_push($return_arr,$row);
}

echo json_encode($return_arr);

?>