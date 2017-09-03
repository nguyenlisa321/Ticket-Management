

<?php
session_start();
if($_SERVER["HTTPS"] != "on") {
header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
}
if(!isset($_SESSION["login"])){
  header("Location: login.php");
  exit;
}
  ?>

<!DOCTYPE html>

<html>
<head>
<title>Technical Support</title>

<link rel = "stylesheet" type = "text/css" href = "style.css"/>

</head>
<body>

 <script type="text/javascript" language="javascript">

 	function show1(){
 		document.getElementById("display").innerHTML ="";
 		document.getElementById("display").innerHTML = "<h3>Create a Ticket</h3> <form name='ticket'><b>First Name </b><input type = 'text' name = 'First_name' size = '30' maxlength = '30' required=''><br /><br /><b>Last Name </b><input type = 'text' name = 'Last_name' size = '30' maxlength = '30' required=''><br /><br /> <b>Email </b> <input type = 'email' name = 'Email' size = '35' maxlength = '30' required=''> <br /><br /> <b>Subject? </b> <input type = 'text' name = 'Subject' size = '60' maxlength = '60' required=''> <br /><br /> <b>Ple/ase type your description below:</b><br /> <br /><textarea name='Description' rows='5'cols='60' required=''></textarea> <br /><br /> <input type = 'button' id='submit' value = 'Submit' onclick='processWritein(\"sendmail.php\")'><input type = 'reset' value ='Reset' id='submit'></form>";

 	}
 	function show2(){
 		document.getElementById("display").innerHTML = "";
 		var text = arguments[0];
 		//alert(JSON.stringify(text));
 		
 		var table = document.createElement('table');
 		var row = document.createElement("tr");
 		

 		var header = document.createElement("th");
 		header.innerHTML = "Ticket #";
 		var header2 = document.createElement("th");
 		header2.innerHTML = "Received";
 		var header3 = document.createElement("th");
 		header3.innerHTML = "Subject";
 		var header4 = document.createElement("th");
 		header4.innerHTML = "Status";

 		row.appendChild(header);
 		row.appendChild(header2);
 		row.appendChild(header3);
 		row.appendChild(header4);


 		table.appendChild(row);

    for(var i =0; i < text.length; i++){
      var row1 = table.insertRow(i+1);
      var cell1 = row1.insertCell(0);
      var cell2 = row1.insertCell(1);
      var cell3 = row1.insertCell(2);
      var cell4 = row1.insertCell(3);
      cell1.innerHTML = text[i].Ticket_Id;
      cell2.innerHTML = text[i].Received;
      cell3.innerHTML = text[i].Subject;
      cell4.innerHTML = text[i].Status;
    }

 		document.getElementById("display").appendChild(table);
 		
 		
 		

 	}
  function show3(){
    document.getElementById("display").innerHTML ="";
    document.getElementById("display").innerHTML = "<h3> Change Password </h3><form name ='password'><b> User Id: </b> <input type='text' name='userid' required=''><br /> <br/><b> New Password: </b> <input type='password' name='password' required=''><br /> <br/><b> Confirm New Password: </b> <input type='password' name='password2' required=''><br /> <br/><input type='button' value='Set New Password' id='submit' onclick='processWritein2(\"changepassword.php\")'>";

  }

 	function processWritein(url)
    {
	    	
        	var first_name = document.ticket.First_name.value;
        	var last_name = document.ticket.Last_name.value;
        	var subject = document.ticket.Subject.value;
        	var email = document.ticket.Email.value;
        	var description = document.ticket.Description.value;
        	var ok = true;
        	if (first_name == "")
        	{
            	alert("Please enter a first name");
            	document.ticket.First_name.focus();
            	ok = false;
        	}
        	if (last_name == "")
        	{
            	alert("Please enter a last name");
            	document.ticket.Last_name.focus();
            	ok = false;
        	}
        	if (subject == "")
        	{
            	alert("Please enter a subject");
            	document.ticket.Subject.focus();
            	ok = false;
        	}
        	if (email == "")
        	{
            	alert("Please enter an email");
            	document.ticket.Email.focus();
            	ok = false;
        	}
        	if (description == "")
        	{
            	alert("Please enter a description");
            	document.ticket.Description.focus();
            	ok = false;
        	}
        	
        	 if (ok)
        	{
            
            processData(url, first_name, last_name, subject, email, description);
       		}
        	
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


 	
 	function processData() {
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
       	var first_name = arguments[1];
       	var last_name = arguments[2];
       	var subject = arguments[3];
       	var email = arguments[4];
       	email = email.replace('+', '%2B')
       	//alert(email);
       	var description = arguments[5];
       	var data = "First_name=" + first_name + "&Last_name=" + last_name + "&Subject=" + subject + "&Email=" + email + "&Description=" + description;
       	//alert(data);
       	httpRequest.onreadystatechange = function() {//Call a function when the state changes.
	  if(httpRequest.readyState == 4 && httpRequest.status == 200) {
		alert("Ticket submission has been sent.");
	}

}
        httpRequest.open('POST', url, true);
         httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
        httpRequest.send(data);

  
}

     function makeRequest(url) {
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
       httpRequest.onreadystatechange = function() {//Call a function when the state changes.
	  if(httpRequest.readyState == 4 && httpRequest.status == 200) {
      //alert(httpRequest.responseText);
	  	var text= JSON.parse(httpRequest.responseText);
	  	show2(text);
		
	}
}
        httpRequest.open('POST', url, true);
        httpRequest.send(null);

  
}
    
 </script>
<b><h1>User Page </h1></b>
<div id="user_buttons">
<input type="button" value="Submit new ticket" onclick = 'show1()' id="submit">
<input type="button" value="View My ticket" onclick = "makeRequest('getTicket.php')" id="submit">
<input type="button" value="Change Password" onclick = 'show3()' id="submit">
</div>
<a href="login.php?logout=true"><input type="button" value="Logout" id="submit"><br /> <br /></a>
<div id="display" align="center">
	
</div>
</body>
</html>