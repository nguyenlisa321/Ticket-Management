<?php
class Ticket {
  //DIFFERENT DATA FIELDS
	  private $received;

    private $first_name;
    private $last_name;

    private $sender_email;

    private $subject;
    private $description;
    private $tech;

    private $status;

    //CONSTRUCTOR
    public function __construct($received, $first, $last, $sender_email, $subject, $description, $tech){
    	$this->received = $received;
    	$this->first_name = $first;
    	$this->last_name = $last;
    	$this->sender_email = $sender_email;
    	$this->subject = $subject;
    	$this->tech = $tech;
    	$this->status = "open";
    	$this->description = $description;

    }

    public function set_status($status){
    	$this->status = $status;
    }

    public function set_tech($tech){
    	$this->tech = $tech;
    }
    //FETCH ID FOR A CERTAIN TICKET
    public function get_id(){
    	$db = new mysqli('localhost', 'root', '', 'assignment3');
      if ($db->connect_error):
         die ("Could not connect to db: " . $db->connect_error);
      endif;

    	$query = "SELECT Ticket_id FROM TIcket WHERE Email='$this->sender_email' and Subject='$this->subject' and Sender_first_name='$this->first_name' and Sender_last_name='$this->last_name'";
       //echo $query;
    	 $results = $db->query($query) or die ("Invalid select " . $db->error);
    	 if($results->num_rows >0){
    	 	$data = $results->fetch_array();
    	 	return $data[0];
    	 }
    	 else {
    	 	echo "Error";
    	 }

    }
    //UPDATE THE CLOSDE/OPEN STATUS
    public function update_status($status){
    	$db = new mysqli('localhost', 'root', '', 'assignment3');
      if ($db->connect_error):
         die ("Could not connect to db: " . $db->connect_error);
      endif;
    	$query = "UPDATE Ticket SET Status='" . $status . "' WHERE Email='" . $this->sender_email . "'and Subject='" . $this->subject . "'";
    	 $results = $db->query($query) or die ("Invalid insert " . $db->error);

    }


    //INPUT NEW TICKET INTO DATABASE
    public function input_db(){
    	$db = new mysqli('localhost', 'root', '', 'assignment3');
      if ($db->connect_error):
         die ("Could not connect to db: " . $db->connect_error);
      endif;

      $query = "INSERT INTO Ticket VALUES (NULL,'$this->first_name', '$this->last_name', '$this->received', '$this->sender_email', '$this->subject', '$this->description', '$this->status')";
      $results = $db->query($query) or die ("Invalid insert " . $db->error);

    }
    //INPUT ID
     public function input_admin($id){
      $db = new mysqli('localhost', 'root', '', 'assignment3');
      if ($db->connect_error):
         die ("Could not connect to db: " . $db->connect_error);
      endif;

      $query = "INSERT INTO Ticket_Admin VALUES ($id, 1)";
      $results = $db->query($query) or die ("Invalid insert " . $db->error);

    }


}


?>