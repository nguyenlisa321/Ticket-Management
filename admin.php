<?php
//echo $_SESSION['First_name'];
//Login handling
if(isset($_POST['Option5'])){
	
		header("Location: login.php?logout=true");
	
}
session_start();

if(!isset($_SESSION["login"])){
  header("Location: login.php");
  exit;	
}
if(isset($_SESSION["Type"])){
    $type = trim($_SESSION["Type"]);
    //echo $type;
    if($type == "regular"){
        header("Location: login.php");
        exit; 
    }
}
?>
<!DOCTYPE html>

<html>
<head>
<title>Admin Page</title>
<link rel = "stylesheet" type = "text/css" href = "style.css"/>
</head>
<script type="text/javascript">
var arr; //All info
var current; //Curent info
//Sort
    function sort(){
        if(document.querySelector('input[name="sort"]:checked').value == "Ticket.First_name"){
        current = current.sort(function(a, b) {
        return a.Sender_first_name.localeCompare(b.Sender_first_name);
        });
    }
        else if(document.querySelector('input[name="sort"]:checked').value == "Ticket.Ticket_id"){
        current = current.sort(function(a, b) {
        return parseInt(a.Ticket_id) - parseInt(b.Ticket_id);
        });
    }
        else if(document.querySelector('input[name="sort"]:checked').value == "Ticket.Received"){
        current = current.sort(function(a, b) {
        var date1 = Date.parse(a.Received);
        var date2 = Date.parse(b.Received);
        //alert(date1);
        return date1 - date2;
        });
    }
    else if(document.querySelector('input[name="sort"]:checked').value == "Ticket.Email"){
        current = current.sort(function(a, b) {
        return a.Email.localeCompare(b.Email);
        });
    }
    else if(document.querySelector('input[name="sort"]:checked').value == "Ticket.Subject"){
        current = current.sort(function(a, b) {
        return a.Subject.localeCompare(b.Subject);
        });
    }
        var i;
        var out = "<table>";
        out += "<tr><th>Ticket #</th><th>Sender Name</th><th>Received</th><th>Email</th><th>Subject</th><th>Tech</th><th>Status</th></tr>";

    for(i = 0; i < current.length; i++) {
        if(current[i]){
        out += "<tr><td>" +
        current[i].Ticket_id +
        "</td><td>" +
        current[i].Sender_first_name +
        " " +
        current[i].Sender_last_name+
        "</td><td>" +
        current[i].Received +
        "</td><td>" +
        current[i].Email+
        "</td><td>"+
        current[i].Subject+
         "</td><td>"+
        current[i].First_name +
        "</td><td>" +
        current[i].Status+
        "</td><td>"+
        "<input type='radio' name='ticket' value='"+current[i].Ticket_id+"'form='Form3' /> </td></tr>";
    }
    }
    out +="<tr><td><input type='radio' name='sort' value='Ticket.Ticket_id' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.First_name' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Received' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Email' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Subject' form='Form2' /> </td></tr>";
    out += "</table>";
    //alert(out);
        document.getElementById("tickets").innerHTML = out;
        
}
//Get initialze info
	function getinfo(url) {
        var httpRequest;
        //alert("hi");
      
        if (window.XMLHttpRequest) { // Mozilla, Safari, ...
            httpRequest = new XMLHttpRequest();
            if (httpRequest.overrideMimeType) {
                httpRequest.overrideMimeType('text/xml');
                // See note below about this line
            }
        } 
        else if (window.ActiveXObject) { // IE
            try {
                httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
                } 
                catch (e) {
                           try {
                                httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
                               } 
                             catch (e) {}
                          }
                                       }

        if (!httpRequest) {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
    httpRequest.onreadystatechange = function() {
    if (httpRequest.readyState == 4 && (httpRequest.status == 200 || httpRequest.status == 0 && httpRequest.responseText)) {
        arr = JSON.parse(httpRequest.responseText);
        var i;
        var out = "<table>";
        out += "<tr><th>Ticket #</th><th>Sender Name</th><th>Received</th><th>Email</th><th>Subject</th><th>Tech</th><th>Status</th></tr>";
    //current = [];
    current = JSON.parse(JSON.stringify(arr));
    for(i = 0; i < arr.length; i++) {

        if(arr[i].Status == "open"){
        
        out += "<tr><td>" +
        arr[i].Ticket_id +
        "</td><td>" +
        arr[i].Sender_first_name +
        " " +
        arr[i].Sender_last_name+
        "</td><td>" +
        arr[i].Received +
        "</td><td>" +
        arr[i].Email+
        "</td><td>"+
        arr[i].Subject+
         "</td><td>"+
        arr[i].First_name +
        "</td><td>" +
        arr[i].Status+
        "</td><td>"+
        "<input type='radio' name='ticket' value='"+arr[i].Ticket_id+"'form='Form3' /> </td></tr>";

    }
        if(arr[i].Status == "closed"){
            delete current[i];
        }
    }
    out +="<tr><td><input type='radio' name='sort' value='Ticket.Ticket_id' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.First_name' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Received' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Email' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Subject' form='Form2' /> </td></tr>";
    out += "</table>";
    
        document.getElementById("tickets").innerHTML = out;
        //alert(JSON.stringify(current));
    }

}
        httpRequest.open('POST', url, true);
        httpRequest.send(null);

  
}
//View all open tickets
function open_tickets(){
    //alert(JSON.stringify(arr));
        var i;
        var out = "<table>";
        out += "<tr><th>Ticket #</th><th>Sender Name</th><th>Received</th><th>Email</th><th>Subject</th><th>Tech</th><th>Status</th></tr>";
    current = JSON.parse(JSON.stringify(arr));

    for(i = 0; i < arr.length; i++) {
        if(arr[i].Status == "open"){
        out += "<tr><td>" +
        arr[i].Ticket_id +
        "</td><td>" +
        arr[i].Sender_first_name +
        " " +
        arr[i].Sender_last_name+
        "</td><td>" +
        arr[i].Received +
        "</td><td>" +
        arr[i].Email+
        "</td><td>"+
        arr[i].Subject+
         "</td><td>"+
        arr[i].First_name +
        "</td><td>" +
        arr[i].Status+
        "</td><td>"+
        "<input type='radio' name='ticket' value='"+arr[i].Ticket_id+"'form='Form3' /> </td></tr>";
    }

    if(arr[i].Status == "closed"){
            delete current[i];
        }
    }
    out +="<tr><td><input type='radio' name='sort' value='Ticket.Ticket_id' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.First_name' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Received' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Email' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Subject' form='Form2' /> </td></tr>";
    out += "</table>";

    
        document.getElementById("tickets").innerHTML = out;

}
//View all tickets
function all_tickets(){
    //alert(JSON.stringify(arr));
        var i;
        var out = "<table>";
        out += "<tr><th>Ticket #</th><th>Sender Name</th><th>Received</th><th>Email</th><th>Subject</th><th>Tech</th><th>Status</th></tr>";
     current = JSON.parse(JSON.stringify(arr));
    for(i = 0; i < arr.length; i++) {
        
        out += "<tr><td>" +
        arr[i].Ticket_id +
        "</td><td>" +
        arr[i].Sender_first_name +
        " " +
        arr[i].Sender_last_name+
        "</td><td>" +
        arr[i].Received +
        "</td><td>" +
        arr[i].Email+
        "</td><td>"+
        arr[i].Subject+
         "</td><td>"+
        arr[i].First_name +
        "</td><td>" +
        arr[i].Status+
        "</td><td>"+
        "<input type='radio' name='ticket' value='"+arr[i].Ticket_id+"'form='Form3' /> </td></tr>";
    
    }
    out +="<tr><td><input type='radio' name='sort' value='Ticket.Ticket_id' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.First_name' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Received' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Email' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Subject' form='Form2' /> </td></tr>";
    out += "</table>";
    //alert(out);
        document.getElementById("tickets").innerHTML = out;

}
//View unassigned tickets
function unassigned_tickets(){
    
        var i;
        var out = "<table>";
        out += "<tr><th>Ticket #</th><th>Sender Name</th><th>Received</th><th>Email</th><th>Subject</th><th>Tech</th><th>Status</th></tr>";
    current = JSON.parse(JSON.stringify(arr));
    for(i = 0; i < arr.length; i++) {
        
        if(arr[i].First_name == ""){
        out += "<tr><td>" +
        arr[i].Ticket_id +
        "</td><td>" +
        arr[i].Sender_first_name +
        " " +
        arr[i].Sender_last_name+
        "</td><td>" +
        arr[i].Received +
        "</td><td>" +
        arr[i].Email+
        "</td><td>"+
        arr[i].Subject+
         "</td><td>"+
        arr[i].First_name +
        "</td><td>" +
        arr[i].Status+
        "</td><td>"+
        "<input type='radio' name='ticket' value='"+arr[i].Ticket_id+"'form='Form3' /> </td></tr>";
    }
        if(arr[i].First_name != ""){
            delete current[i];
        }
    
    }
    out +="<tr><td><input type='radio' name='sort' value='Ticket.Ticket_id' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.First_name' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Received' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Email' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Subject' form='Form2' /> </td></tr>";
    out += "</table>";
    //alert(out);
        document.getElementById("tickets").innerHTML = out;

}
//View my ticket
function my_ticket(){
    var sessionValue = "<?php echo $_SESSION['First_name']?>";
    //alert(sessionValue);
    var i;
        var out = "<table>";
        out += "<tr><th>Ticket #</th><th>Sender Name</th><th>Received</th><th>Email</th><th>Subject</th><th>Tech</th><th>Status</th></tr>";
    current = JSON.parse(JSON.stringify(arr));    
    for(i = 0; i < arr.length; i++) {
        
        if(arr[i].First_name == sessionValue){
        out += "<tr><td>" +
        arr[i].Ticket_id +
        "</td><td>" +
        arr[i].Sender_first_name +
        " " +
        arr[i].Sender_last_name+
        "</td><td>" +
        arr[i].Received +
        "</td><td>" +
        arr[i].Email+
        "</td><td>"+
        arr[i].Subject+
         "</td><td>"+
        arr[i].First_name +
        "</td><td>" +
        arr[i].Status+
        "</td><td>"+
        "<input type='radio' name='ticket' value='"+arr[i].Ticket_id+"'form='Form3' /> </td></tr>";
    }
    if(arr[i].First_name != sessionValue){
        delete current[i];
    }    
    }
    out +="<tr><td><input type='radio' name='sort' value='Ticket.Ticket_id' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.First_name' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Received' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Email' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Subject' form='Form2' /> </td></tr>";
    out += "</table>";
    //alert(out);
        document.getElementById("tickets").innerHTML = out;

}
//Change password
  function show3(){
    document.getElementById("tickets").innerHTML ="";
    document.getElementById("tickets").innerHTML = "<h3> Change Password </h3><form name ='password'><b> User Id: </b> <input type='text' name='userid' required=''><br /> <br/><b> New Password: </b> <input type='password' name='password' required=''><br /> <br/><b> Confirm New Password: </b> <input type='password' name='password2' required=''><br /> <br/><input type='button' value='Set New Password' id='submit' onclick='processWritein2(\"changepassword.php\")'>";

  }

    function processWritein2(url)
    {
        
          var id = document.password.userid.value;
          var pass1 = document.password.password.value;
          var pass2 = document.password.password2.value;
          
          var ok = true;
          if (id == "")
          {
              alert("Please enter a valid userid");
              document.password.userid.focus();
              ok = false;
          }
          if (pass1 == "")
          {
              alert("Please enter a new password");
              document.password.password.focus();
              ok = false;
          }
          if (pass2 == "")
          {
              alert("Please confirm password");
              document.password.password2.focus();
              ok = false;
          }

          if (pass1 != pass2){
            alert("Passwords don't match");
            ok = false;
          }

           if (ok)
          {
            
            processData2(url, id, pass1);
          }
          
    }
  function processData2() {
        var httpRequest;
        //alert("hi");
     
        if (window.XMLHttpRequest) { // Mozilla, Safari, ...
            httpRequest = new XMLHttpRequest();
            if (httpRequest.overrideMimeType) {
                httpRequest.overrideMimeType('text/xml');
                // See note below about this line
            }
        } 
        else if (window.ActiveXObject) { // IE
            try {
                httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
                } 
                catch (e) {
                           try {
                                httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
                               } 
                             catch (e) {}
                          }
                                       }

        if (!httpRequest) {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
        //set variables to send to sendmail.php
        var url = arguments[0];
        var id = arguments[1];
        var pass = arguments[2];
        var data = "userid=" + id + "&password=" + pass;
        //alert(data);
        httpRequest.onreadystatechange = function() {//Call a function when the state changes.
    if(httpRequest.readyState == 4 && httpRequest.status == 200) {
    alert(httpRequest.responseText);
  }

}
        httpRequest.open('POST', url, true);
         httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
        httpRequest.send(data);

  
}
//View selected ticket
function selected(){
    ticket = document.querySelector('input[name="ticket"]:checked').value;
      var i;
        var out = "<table>";
        out += "<tr><th>Ticket #</th><th>Sender Name</th><th>Received</th><th>Email</th><th>Subject</th><th>Description</th><th>Tech</th><th>Status</th></tr>";
        for(i = 0; i < arr.length; i++) {
        
        if(arr[i].Ticket_id == ticket){
        out += "<tr><td>" +
        arr[i].Ticket_id +
        "</td><td>" +
        arr[i].Sender_first_name +
        " " +
        arr[i].Sender_last_name+
        "</td><td>" +
        arr[i].Received +
        "</td><td>" +
        arr[i].Email+
        "</td><td>"+
        arr[i].Subject+
         "</td><td>"+
        arr[i].Description+
         "</td><td>"+
        arr[i].First_name +
        "</td><td>" +
        arr[i].Status+
        "</td></tr>";
        id = arr[i].Ticket_id;
        status = arr[i].Status;
        first = arr[i].Sender_first_name;
        last = arr[i].Sender_last_name;
        subject = arr[i].Subject;
        receiver = arr[i].Email;
        
    }

 
}
           out += "</table>";
    //alert(out);
        document.getElementById("tickets").innerHTML = out;
        document.getElementById("buttons").style.display = "none";
        document.getElementById("mail").style.display = "inline";
        document.getElementById("buttons2").style.display = "inline";
}
//Return to admin main page
function goback(){
        document.getElementById("buttons").style.display = "inline";
        document.getElementById("mail").style.display = "none";
        document.getElementById("buttons2").style.display = "none";
        open_tickets();
}
//View updated select page
function reselected(){
        var i;
        var out = "<table>";
        out += "<tr><th>Ticket #</th><th>Sender Name</th><th>Received</th><th>Email</th><th>Subject</th><th>Description</th><th>Tech</th><th>Status</th></tr>";
        for(i = 0; i < arr.length; i++) {
        
        if(arr[i].Ticket_id == ticket){
        out += "<tr><td>" +
        arr[i].Ticket_id +
        "</td><td>" +
        arr[i].Sender_first_name +
        " " +
        arr[i].Sender_last_name+
        "</td><td>" +
        arr[i].Received +
        "</td><td>" +
        arr[i].Email+
        "</td><td>"+
        arr[i].Subject+
         "</td><td>"+
        arr[i].Description+
         "</td><td>"+
        arr[i].First_name +
        "</td><td>" +
        arr[i].Status+
        "</td></tr>";
        id = arr[i].Ticket_id;
        status = arr[i].Status;
        first = arr[i].Sender_first_name;
        last = arr[i].Sender_last_name;
        subject = arr[i].Subject;
        receiver = arr[i].Email;
        
    }

 
}
           out += "</table>";
    //alert(out);
        document.getElementById("tickets").innerHTML = out;
        document.getElementById("buttons").style.display = "none";
        document.getElementById("mail").style.display = "inline";
        document.getElementById("buttons2").style.display = "inline";
}
//sendmail to submitter
function sendmail(){
        var message = document.Form3.message.value;
        var httpRequest;
        //alert("hi");
      
        if (window.XMLHttpRequest) { // Mozilla, Safari, ...
            httpRequest = new XMLHttpRequest();
            if (httpRequest.overrideMimeType) {
                httpRequest.overrideMimeType('text/xml');
                // See note below about this line
            }
        } 
        else if (window.ActiveXObject) { // IE
            try {
                httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
                } 
                catch (e) {
                           try {
                                httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
                               } 
                             catch (e) {}
                          }
                                       }

        if (!httpRequest) {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
    httpRequest.onreadystatechange = function() {
    if (httpRequest.readyState == 4 && (httpRequest.status == 200 || httpRequest.status == 0 && httpRequest.responseText)) {
        alert( httpRequest.responseText);
        
    } 
}       
        var message = document.Form3.message.value;
        receiver = receiver.replace("+", "%2B");
        //alert(receiver);
        var data = "message=" + message +"&subject="+subject +"&receiver=" + receiver;
        
        httpRequest.open('POST', 'mail.php', true);
        httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
        httpRequest.send(data);


}
//View tickets by same submitter
function same(){
    var i;
        var out = "<table>";
        out += "<tr><th>Ticket #</th><th>Sender Name</th><th>Received</th><th>Email</th><th>Subject</th><th>Tech</th><th>Status</th></tr>";
    current = JSON.parse(JSON.stringify(arr));
    for(i = 0; i < arr.length; i++) {
        
        if(arr[i].Sender_first_name == first && arr[i].Sender_last_name == last){
        out += "<tr><td>" +
        arr[i].Ticket_id +
        "</td><td>" +
        arr[i].Sender_first_name +
        " " +
        arr[i].Sender_last_name+
        "</td><td>" +
        arr[i].Received +
        "</td><td>" +
        arr[i].Email+
        "</td><td>"+
        arr[i].Subject+
         "</td><td>"+
        arr[i].First_name +
        "</td><td>" +
        arr[i].Status+
        "</td><td>"+
        "<input type='radio' name='ticket' value='"+arr[i].Ticket_id+"'form='Form3' /> </td></tr>";
    }
        else {
            delete current[i];
        }
    
    }
    out +="<tr><td><input type='radio' name='sort' value='Ticket.Ticket_id' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.First_name' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Received' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Email' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Subject' form='Form2' /> </td></tr>";
    out += "</table>";
    //alert(out);
        document.getElementById("tickets").innerHTML = out;
         document.getElementById("buttons").style.display = "inline";
        document.getElementById("mail").style.display = "none";
        document.getElementById("buttons2").style.display = "none";

}
//View similar tickets
function similar(){
    var i, j;
        var out = "<table>";
        out += "<tr><th>Ticket #</th><th>Sender Name</th><th>Received</th><th>Email</th><th>Subject</th><th>Tech</th><th>Status</th></tr>";
    current = JSON.parse(JSON.stringify(arr));
    var words = subject.split(" ");

    for(i = 0; i < arr.length; i++) {
        var match = false;
        for(j=0; j < words.length; j++)  {
            if(arr[i].Subject.includes(words[j])){
                match = true;
            }
        }
        if(match){
        out += "<tr><td>" +
        arr[i].Ticket_id +
        "</td><td>" +
        arr[i].Sender_first_name +
        " " +
        arr[i].Sender_last_name+
        "</td><td>" +
        arr[i].Received +
        "</td><td>" +
        arr[i].Email+
        "</td><td>"+
        arr[i].Subject+
         "</td><td>"+
        arr[i].First_name +
        "</td><td>" +
        arr[i].Status+
        "</td><td>"+
        "<input type='radio' name='ticket' value='"+arr[i].Ticket_id+"'form='Form3' /> </td></tr>";
    }
        else {
            delete current[i];
        }
    
    }
    out +="<tr><td><input type='radio' name='sort' value='Ticket.Ticket_id' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.First_name' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Received' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Email' form='Form2' /> </td>"+
         "<td><input type='radio' name='sort' value='Ticket.Subject' form='Form2' /> </td></tr>";
    out += "</table>";
    //alert(out);
        document.getElementById("tickets").innerHTML = out;
         document.getElementById("buttons").style.display = "inline";
        document.getElementById("mail").style.display = "none";
        document.getElementById("buttons2").style.display = "none";

}
//Change status
function change_status(){
        var httpRequest;
        //alert("hi");
      
        if (window.XMLHttpRequest) { // Mozilla, Safari, ...
            httpRequest = new XMLHttpRequest();
            if (httpRequest.overrideMimeType) {
                httpRequest.overrideMimeType('text/xml');
                // See note below about this line
            }
        } 
        else if (window.ActiveXObject) { // IE
            try {
                httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
                } 
                catch (e) {
                           try {
                                httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
                               } 
                             catch (e) {}
                          }
                                       }

        if (!httpRequest) {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
    httpRequest.onreadystatechange = function() {
    if (httpRequest.readyState == 4 && (httpRequest.status == 200 || httpRequest.status == 0 && httpRequest.responseText)) {
        arr = JSON.parse(httpRequest.responseText);
        reselected();
        
    } 
}       
        
        var data = "status=" + status+ "&id=" + id;
        httpRequest.open('POST', 'ticket.php', true);
        httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
        httpRequest.send(data);


}
//Assign self
function assign(){
        var httpRequest;
        //alert("hi");
      
        if (window.XMLHttpRequest) { // Mozilla, Safari, ...
            httpRequest = new XMLHttpRequest();
            if (httpRequest.overrideMimeType) {
                httpRequest.overrideMimeType('text/xml');
                // See note below about this line
            }
        } 
        else if (window.ActiveXObject) { // IE
            try {
                httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
                } 
                catch (e) {
                           try {
                                httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
                               } 
                             catch (e) {}
                          }
                                       }

        if (!httpRequest) {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
    httpRequest.onreadystatechange = function() {
    if (httpRequest.readyState == 4 && (httpRequest.status == 200 || httpRequest.status == 0 && httpRequest.responseText)) {
        arr = JSON.parse(httpRequest.responseText);
        reselected();
        
    } 
}       
        var userid = "<?php echo $_SESSION['userid']?>";
        var data = "assign=" + userid + "&id=" + id;
        httpRequest.open('POST', 'ticket.php', true);
        httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
        httpRequest.send(data);


}
//Remove self
function remove(){
        var httpRequest;
        //alert("hi");
      
        if (window.XMLHttpRequest) { // Mozilla, Safari, ...
            httpRequest = new XMLHttpRequest();
            if (httpRequest.overrideMimeType) {
                httpRequest.overrideMimeType('text/xml');
                // See note below about this line
            }
        } 
        else if (window.ActiveXObject) { // IE
            try {
                httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
                } 
                catch (e) {
                           try {
                                httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
                               } 
                             catch (e) {}
                          }
                                       }

        if (!httpRequest) {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
    httpRequest.onreadystatechange = function() {
    if (httpRequest.readyState == 4 && (httpRequest.status == 200 || httpRequest.status == 0 && httpRequest.responseText)) {
        arr = JSON.parse(httpRequest.responseText);
        reselected();
        
    } 
}       
        var userid = "<?php echo $_SESSION['userid']?>";
        var data = "remove=" + userid + "&id=" + id;
        httpRequest.open('POST', 'ticket.php', true);
        httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
        httpRequest.send(data);
        

}
//Delete Ticket
function deleteT(){
        var httpRequest;
        //alert("hi");
      
        if (window.XMLHttpRequest) { // Mozilla, Safari, ...
            httpRequest = new XMLHttpRequest();
            if (httpRequest.overrideMimeType) {
                httpRequest.overrideMimeType('text/xml');
                // See note below about this line
            }
        } 
        else if (window.ActiveXObject) { // IE
            try {
                httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
                } 
                catch (e) {
                           try {
                                httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
                               } 
                             catch (e) {}
                          }
                                       }

        if (!httpRequest) {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
    httpRequest.onreadystatechange = function() {
    if (httpRequest.readyState == 4 && (httpRequest.status == 200 || httpRequest.status == 0 && httpRequest.responseText)) {
        arr = JSON.parse(httpRequest.responseText);
        reselected();
        
    } 
}       
        
        var data = "delete=" + id;
        httpRequest.open('POST', 'ticket.php', true);
        httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
        httpRequest.send(data);


}
getinfo('tables_redo.php');
</script>
<body>
<b><h1>Admin Page </h1></b>
<!--Display button options -->
<div id="buttons">
<input type="button" value="View All Open Tickets" onclick="open_tickets()" id="submit">
<input type="button" value="View All Tickets" onclick="all_tickets()" id="submit">
<input type="button" value="View My Tickets" onclick="my_ticket()" id="submit">
<input type="button" value="View Unassigned Tickets" onclick="unassigned_tickets()" id="submit">
<input type="button" value="View Selected Tickets" onclick="selected()" id="submit">
<input type="button" value="Sort" onclick="sort()" id="submit">
<input type="button" value="Change Password" onclick = 'show3()' id="submit">
<input type="button" value="Logout" onclick="document.location.href = 'login.php?logout=true'" id="submit">
<br /> <br />
</div>
<!-- Display Ticket Options -->
<div id="buttons2" align="center" style="display: none;">
<input type='submit' name='Option10' value='Close / reopen the ticket' onclick='change_status()' id='submit'/>
    <input type='submit' name='Option11' value='Assign self to the ticket' onclick='assign()' id='submit'/>
    <input type='submit' name='Option12' value='Remove self from ticket' onclick='remove()' id='submit'/> 
    <input type='submit' name='Option13' value='Delete the ticket' onclick='deleteT()' id='submit'/>
    <input type='submit' name='Option8' value='Find all other tickets from the same submitter' onclick='same()' id='submit'/>
    <input type='submit' name='Option9' value='Find all similar tickets' onclick='similar()' id='submit'/>
    <input type='submit' name='Option7' value='Go back to the main administrator page.' onclick='goback()' id='submit'/>
</div>
<!-- Display table -->
<div id="tickets" align="center">
      <form id="Form2" name="Form2" method="post"></form>
      
</div>
<div id="mail" align="center" display="none" style="display: none;">
<br /><br />
    <form id="Form3" name="Form3"  method="post"></form>
    <b>Please type your message below:</b><br />
    <br />
    <textarea name="message" rows="5" cols="60" form="Form3"></textarea>
    <br /><br />
    <input type='submit' name='Option14' value='Email the submitter' onclick='sendmail()' id='submit'/>
</div>
</body>
</html>