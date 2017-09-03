

<?php
session_start();
		$db = new mysqli('localhost', 'root', '', 'assignment3');
      	if ($db->connect_error):
        die ("Could not connect to db: " . $db->connect_error);
        endif;
        // TECHNICAL SUPPORT ALL TICKETS
        if(isset($_POST['Option1'])){

        	$query = "SELECT Ticket.*, User.First_name, User.Last_name FROM Ticket, Ticket_Admin, User WHERE Ticket.Ticket_id = Ticket_Admin.Ticket_id and Ticket_Admin.User_id= User.User_id "; #Define query
         	$results = $db->query($query) or die ("Invalid select " . $db->error);  #Eval and store result
        	$rows = $results->num_rows;
        	$title = "Technical Support All Tickets"; 
        	//echo $rows;

        } 
        // TECHNICAL SUPPORT UNASSIGNED TICKETS
        else if(isset($_POST['Option6'])){
        	$query = "SELECT Ticket.*, User.First_name, User.Last_name FROM Ticket, Ticket_Admin, User WHERE Ticket.Ticket_id = Ticket_Admin.Ticket_id and Ticket_Admin.User_id= User.User_id and Ticket_Admin.User_id = 1 "; #Define query
         	$results = $db->query($query) or die ("Invalid select " . $db->error);  #Eval and store result
        	$rows = $results->num_rows;
        	$title = "Technical Support Unassigned Tickets"; 

        }
        // TECHINICAL SUPPORT SAME TICKETS BY SUBMITTER
         else if(isset($_POST['Option8'])){
            $id = $_SESSION['ticket'];
            $query = "SELECT Ticket.First_name, Ticket.Last_name FROM Ticket, Ticket_Admin, User WHERE Ticket.Ticket_id = Ticket_Admin.Ticket_id and Ticket_Admin.User_id= User.User_id and Ticket.Ticket_id = $id"; #Define query
            $results = $db->query($query) or die ("Invalid select " . $db->error);
            $data = $results->fetch_array();
            $query = "SELECT Ticket.*, User.First_name, User.Last_name FROM Ticket, Ticket_Admin, User WHERE Ticket.Ticket_id = Ticket_Admin.Ticket_id and Ticket_Admin.User_id= User.User_id and Ticket.First_name = '$data[0]' and Ticket.Last_name = '$data[1]'"; 

            $results = $db->query($query) or die ("Invalid select " . $db->error);  #Eval and store result
            $rows = $results->num_rows;
            $title = "Technical Support Same Tickets By Submitter"; 

        }
        //TECHNICAL SUPPORT SIMILAR TICKETS
        else if(isset($_POST['Option9'])){
            $id = $_SESSION['ticket'];
            $query = "SELECT Ticket.Subject FROM Ticket, Ticket_Admin, User WHERE Ticket.Ticket_id = Ticket_Admin.Ticket_id and Ticket_Admin.User_id= User.User_id and Ticket.Ticket_id = $id"; #Define query
            $results = $db->query($query) or die ("Invalid select " . $db->error);
            $data = $results->fetch_array();
            $datastring  = rtrim($data[0]);
            $keywords  = preg_split("/ +/", $datastring);
            $input = "";
            for($i=0; $i < count($keywords); $i++) {
                if($i != count($keywords)-1 ){
                $input = $input . "SELECT Ticket.*, User.First_name, User.Last_name FROM Ticket, Ticket_Admin, User WHERE Ticket.Ticket_id = Ticket_Admin.Ticket_id and Ticket_Admin.User_id= User.User_id and  Ticket.Subject LIKE '%$keywords[$i]%' UNION ";}
                else
                $input = $input . "SELECT Ticket.*, User.First_name, User.Last_name FROM Ticket, Ticket_Admin, User WHERE Ticket.Ticket_id = Ticket_Admin.Ticket_id and Ticket_Admin.User_id= User.User_id and Ticket.Subject LIKE '%$keywords[$i]%'";
            }
            $query = $input;
            //echo $query;
            $results = $db->query($query) or die ("Invalid select " . $db->error);  #Eval and store result
            $rows = $results->num_rows;
            $title = "Technical Support Similar Tickets"; 

        }
        //TECHNICAL SUPPORT MY TICKETS
        else if(isset($_POST['Option4'])){
        	$id = $_SESSION['userid'];
        	$query = "SELECT Ticket.*, User.First_name, User.Last_name FROM Ticket, Ticket_Admin, User WHERE Ticket.Ticket_id = Ticket_Admin.Ticket_id and Ticket_Admin.User_id= User.User_id and User.Id = '$id' "; #Define query
         	$results = $db->query($query) or die ("Invalid select " . $db->error);  #Eval and store result
        	$rows = $results->num_rows;
        	$title = "Technical Support My Tickets"; 
}
        //TECHNICAL SUPPORT SORTED TICKETS
		else if(isset($_POST['sort'])){
		$order = $_POST['sort'];
		//echo $order;
		$query = "SELECT Ticket.*, User.First_name, User.Last_name FROM Ticket, Ticket_Admin, User WHERE Ticket.Ticket_id = Ticket_Admin.Ticket_id and Ticket_Admin.User_id= User.User_id ORDER BY $order"; #Define query
         	$results = $db->query($query) or die ("Invalid select " . $db->error);  #Eval and store result
        	$rows = $results->num_rows;
        	$title = "Technical Support Sorted Tickets"; 

		}
        //TECHNICAL SUPPORT OPEN TICKETS
        else{
         $query = "SELECT Ticket.*, User.First_name, User.Last_name FROM Ticket, Ticket_Admin, User WHERE Ticket.Ticket_id = Ticket_Admin.Ticket_id and Ticket_Admin.User_id= User.User_id and Ticket.Status = 'open' "; #Define query
         $results = $db->query($query) or die ("Invalid select " . $db->error);  #Eval and store result
         $rows = $results->num_rows; #Det. num. of rows
         $title = "Technical Support Open Tickets";
         }
         //print_r($data);
?>
	  <form id="Form1" name="Form1" action="admin.php" method="post"></form>
      <form id="Form2" name="Form2" action="admin.php" method="post"></form>
      <form id="Form3" name="Form3" action="ticket.php" method="post"></form>
      <table >
      <caption><h3><?php echo $title?></h3></caption>
      <tr align = "center">
<?php
		 $keys = array( "Ticket #", "Sender Name", "Received", "Email", "Subject", "Tech", "Status", "Select");
         foreach ($keys as $key): 
         
             echo "<th>$key</th>";
         endforeach;
         echo "</tr>";
         //PRINT OUT TABLE
         for($i =0; $i < $rows; $i++){
         	$data = $results->fetch_array();
         	
         	echo "<td> $data[0] </td>";
         	echo "<td> $data[1] $data[2] </td>";
         	echo "<td> $data[3] </td>";
         	echo "<td> $data[4] </td>";
         	echo "<td> $data[5] </td>";
         	echo "<td> $data[8] </td>";
         	echo "<td> $data[7] </td>";
         	echo "<td><input type='radio' name='ticket' value=$data[0] form='Form3' /> </td>";
         	echo "</tr>";

         }
         echo "<td><input type='radio' name='sort' value='Ticket.Ticket_id' form='Form2' /> </td>";
         echo "<td><input type='radio' name='sort' value='Ticket.First_name' form='Form2' /> </td>";
         echo "<td><input type='radio' name='sort' value='Ticket.Received' form='Form2' /> </td>";
         echo "<td><input type='radio' name='sort' value='Ticket.Email' form='Form2' /> </td>";
         echo "<td><input type='radio' name='sort' value='Ticket.Subject' form='Form2' /> </td>";
         echo "</tr>";
         echo "</tr>";
         //show_buttons();
//TOGGLE DIFFERENT BUTTONS
function show_buttons(){
	if(isset($_POST['Option1'])){
		echo "<td><input type='submit' name='Option7' value='View Open Tickets' form='Form1' /> </td>";
		echo "<td><input type='submit' name='Option2' value='Sort' form='Form2' /> </td>";
		echo "<td><input type='submit' name='Option3' value='View Selected Ticket' form='Form3' /> </td>";
		echo "</tr>";
		echo "<td><input type='submit' name='Option4' value='View My Tickets' form='Form1' /> </td>";
		echo "<td><input type='submit' name='Option5' value='Logout' form='Form1' /> </td>";
		echo "<td><input type='submit' name='Option6' value='View Unassigned Ticket' form='Form1' /> </td>";
		echo "</tr>";

	} 
	else if(isset($_POST['Option6'])){
		echo "<td><input type='submit' name='Option1' value='View All Tickets' form='Form1' /> </td>";
		echo "<td><input type='submit' name='Option2' value='Sort' form='Form2' /> </td>";
		echo "<td><input type='submit' name='Option3' value='View Selected Ticket' form='Form3' /> </td>";
		echo "</tr>";
		echo "<td><input type='submit' name='Option4' value='View My Tickets' form='Form1' /> </td>";
		echo "<td><input type='submit' name='Option5' value='Logout' form='Form1' /> </td>";
		echo "<td><input type='submit' name='Option7' value='View Open Tickets' form='Form1' /> </td>";
		echo "</tr>";
	}	

	else if(isset($_POST['Option4'])){
		echo "<td><input type='submit' name='Option1' value='View All Tickets' form='Form1' /> </td>";
		echo "<td><input type='submit' name='Option2' value='Sort' form='Form2' /> </td>";
		echo "<td><input type='submit' name='Option3' value='View Selected Ticket' form='Form3' /> </td>";
		echo "</tr>";
		echo "<td><input type='submit' name='Option7' value='View Open Tickets' form='Form1' /> </td>";
		echo "<td><input type='submit' name='Option5' value='Logout' form='Form1' /> </td>";
		echo "<td><input type='submit' name='Option6' value='View Unassigned Ticket' form='Form1' /> </td>";
		echo "</tr>";
	}

	else {
	echo "<td><input type='submit' name='Option1' value='View All Tickets' form='Form1' /> </td>";
	echo "<td><input type='submit' name='Option2' value='Sort' form='Form2' /> </td>";
	echo "<td><input type='submit' name='Option3' value='View Selected Ticket' form='Form3' /> </td>";
	echo "</tr>";
	echo "<td><input type='submit' name='Option4' value='View My Tickets' form='Form1' /> </td>";
	echo "<td><input type='submit' name='Option5' value='Logout' form='Form1' /> </td>";
	echo "<td><input type='submit' name='Option6' value='View Unassigned Ticket' form='Form1' /> </td>";
	echo "</tr>";
}

}
      
?>
<!--a href="login.php?logout=true"> Logout </a-->

