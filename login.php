
<?php

session_start();
if(isset($_POST["id"])){
$_SESSION["userid"] = $_POST["id"];
$_SESSION["pass"] = $_POST["password"];
$db = new mysqli('localhost', 'root', '', 'assignment3');
      if ($db->connect_error):
         die ("Could not connect to db: " . $db->connect_error);
      endif;
$userid = $_SESSION["userid"];
$password = hash("md5", $_SESSION["pass"]);
$query = "SELECT First_name, Last_name, Id, Password, Type FROM User WHERE Id='". $userid ."'and Password='". $password ."'";
$results = $db->query($query) or die ("Invalid Select " . $db->error);
$data = $results->fetch_array();
      //IF FOUND IN DATABSE
      if($results->num_rows > 0){
        //CHECK IF ADMIN OR REGULAR USER
        if(trim($data['Type']) == "admin"){
         
          setcookie("login", $_SESSION["userid"] , time()+6000);
          $_SESSION['Type'] = $data['Type'];
          $_SESSION['First_name'] = $data['First_name'];
          $_SESSION['Last_name'] = $data['Last_name'];
          $_SESSION['Email'] = $data['Email'];
          //setcookie("admin", $_SESSION["userid"] , time()+6000);
          $_SESSION["login"] = true;
           header("Location: admin.php");
           exit;
        }
        else{
          
          setcookie("login", $_SESSION["userid"] , time()+6000);
          setcookie("regular", $_SESSION["userid"] , time()+6000);
          $_SESSION["login"] = true;
          $_SESSION['Type'] = $data['Type'];
          $_SESSION['First_name'] = $data['First_name'];
          $_SESSION['Last_name'] = $data['Last_name'];
          $_SESSION['Email'] = $data['Email'];
          header("Location: user.php");
          exit;
        }
      } else{
        echo "<span style='color: red;'>Incorrect User ID or Password</span><br/>";
      }
}
// Time zone is needed for the date() function used below
date_default_timezone_set('America/New_York');
//Check of user is being changed
if(isset($_GET["logout"])){
  setcookie("login", $_SESSION["userid"] , time()-600);
  setcookie("regular", $_SESSION["userid"] , time()-600);

  unset( $_SESSION["login"]);
  header("Location: login.php");
  exit;
}
//If keep login was checked earliar, log the same user in
if(isset($_COOKIE["login"])){
  show_header();
  if(isset($_COOKIE["regular"])){
  header("Location: user.php");
  exit;
  } else {
    header("Location: admin.php");
    exit;
  }
  show_end();
} else{
//Get login information
    show_header();
    echo '<div id="login">';
    get_info();
    echo '</div>';
    show_end();
}

function show_end()
{
    echo "</html>";
}

function show_header()
{
?>
<!DOCTYPE html>

<html>
<head>
<title>Technical Support</title>

<link rel = "stylesheet" type = "text/css" href = "style.css"/>
</head>
<script type="text/javascript">
//Forget Password Form
  function forgot(){
    document.getElementById("login").innerHTML = "<h3> Forgot Password </h3><form name ='forgot' ><b> User Id: </b> <input type='text' name='userid' required=''><br /> <br/><b> Email: </b> <input type='Email'name='email' required=''><br /> <br/><input type='button' value='Submit' id='submit' onclick='makeRequest(\"forgotpassword.php\")'><input type='button' value='Back' id='submit' onclick='back()'>";

  }
  // Register Form
  function register(){
    document.getElementById("login").innerHTML = "<h3> Register Here </h3><form name ='register' ><b> User Id: </b> <input type='text' name='userid' required=''><br /> <br/><b> First Name: </b> <input type='text'name='first_name' required=''><br /> <br/><b> Last Name: </b> <input type='text'name='last_name' required=''><br /> <br/><b> Email: </b> <input type='Email'name='email' required=''><br /> <br/><b> Password: </b> <input type='password' name='password' required=''><br /> <br/><b> Confirm Password: </b> <input type='password' name='password2' required=''><br /> <br/><input type='button' value='Submit' id='submit' onclick='makeUser(\"register.php\")'><input type='button' value='Back' id='submit' onclick='back()'>";

  }
  //Input new user to Database
  function makeUser(url){
    var id = document.register.userid.value;
    var first_name = document.register.first_name.value;
    var last_name = document.register.last_name.value;
    var email = document.register.email.value;
    var password = document.register.password.value;
    var password2 = document.register.password2.value;
     if(id == "" || first_name== "" || last_name == "" || email =="" || password =="" || password2== ""){
      alert("Input Error");
    }
    else if ( password != password2){
      alert("Password do not match");
    }
    else {
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
       email = email.replace('+', '%2B');
        var data = "id=" + id+"&email=" + email + "&first_name=" + first_name + "&last_name=" + last_name + "&password=" + password2;
        alert("You have registered");
        httpRequest.onreadystatechange = function() {//Call a function when the state changes.
    if(httpRequest.readyState == 4 && httpRequest.status == 200) {
    //alert(httpRequest.responseText);
  }
}

        httpRequest.open('POST', url, true);
         httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
        httpRequest.send(data);
}
  }
  //Fetch user Tickets
  function makeRequest(url){
    var user = document.forgot.userid.value;
    var email = document.forgot.email.value;
    email = email.replace('+', '%2B');
    if(user == "" || email == ""){
      alert("Input Error");
    }
    else {
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
       
        var data = "userid=" + user +"&email=" + email;
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
  }

 function back(){
  location.reload();
 }
</script>
<?php
}
   

//Form for login information
function get_info()
{
  ?><b><h1>Technical Support</h1></b> <br />Login Here <br /> <br /><form name = "infoform"action = "login.php"method = "POST">User ID: <input type = "text" name = "id" required=""><br /><br />Password: <input type = "password" name = "password" required=""><br /><input type = "submit" value = "Login" id="submit"></form>Forgot your password?<a href="javascript:forgot()"> Click here to reset it. </a><br /><br />Not a user?<a href="javascript:register()"> Click here to register. </a><?php
}