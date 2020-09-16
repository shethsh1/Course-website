<?php
    include("config.php");
    session_start();
    $message = NULL;
    $success = NULL;
   
    if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
        $myusername = mysqli_real_escape_string($db,$_POST['username']);
        $mypassword = mysqli_real_escape_string($db,$_POST['password1']);
        $mypassword2 = mysqli_real_escape_string($db,$_POST['password2']);
        $role = mysqli_real_escape_string($db,$_POST['role']);





        if($mypassword != $mypassword2) {
            $message = "Passwords do not match";

        } else if((strlen($myusername) < 4 || strlen($mypassword) < 4) || (ctype_alnum($myusername) == FALSE || ctype_alnum($mypassword)== FALSE)) {
      	    $message = "username & password must be greater than three characters and strictly alphanumeric";
        } else if(strtolower($role) != "ta" && strtolower($role) != "instructor" && strtolower($role) != "student") {
      	    $message = "role must be either Student, Instructor, or TA";
        } else if(strlen($myusername) > 64 || strlen($mypassword) > 64) {
            $message = "user/pass be above 64 characters";
        } else {
            $sql = "SELECT username FROM users WHERE username = '$myusername'";
            $result = mysqli_query($db,$sql);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $count = mysqli_num_rows($result);


            if($count == 1) {
                $message = "username already exist please use another";
            } else {
                $sql = "insert into users values ('$myusername', '$mypassword', '$role');";
                $result = mysqli_query($db,$sql);
                if(strtolower($role) == "student") {
                    $sq2 = "SELECT DISTINCT assignmentName, assignmentWeight FROM grades;";
                    $result = mysqli_query($db,$sq2);
                    while($row = $result->fetch_assoc()) {
                        $a = $row['assignmentName'];
                        $weight = $row['assignmentWeight'];
                        $sq3 = "insert into grades values ('$myusername', '$a', '$weight', NULL, false, NULL, NULL);";
                        $result3 = mysqli_query($db,$sq3);
                    }
                }
            
                $success = "successfully created your account";
          }
        
        }

    }
?>
<html>

	<head>

		<title>CSCB20 Registration</title>
		<link rel="stylesheet" type="text/css"
		href="index.css">

	</head>

	<body>



		<div class="loginbox2">
		<img src="a3.png" class="avatar">
			<h1 id="logintitle">Create Account</h1>


	    	<form action = "" method = "post">
	    		
	        	<label>Username </label><br>
	        	<input type = "text" name = "username" class = "box" placeholder="Enter Username"/><br /><br />
	        	<label>Password </label><br>
	          <input type = "password" name = "password1" class = "box" placeholder="Enter Password" /><br/><br />
	          <label>Re-enter Password </label><br>
	          <input type = "password" name = "password2" class = "box" placeholder="Re-enter Password" /><br/><br />
	          <label>Role (E.g. TA, Instructor, Student) </label><br>
	          <input type = "text" name = "role" class = "box" placeholder="Enter role" /><br/><br />
	          <input type = "submit" value = " Create "/><br>
	          <a href="login.php">Back to login?</a>
	          <div style = "font-size:11px; color:#cc0000; margin-top:0px"><?php echo $message; ?></div>
            <div style = "font-size:11px; color:green; margin-top:0px"><?php echo $success; ?></div>
	       </form>

       </div>

	</body>




</html>