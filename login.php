<?php
   include("config.php");
   session_start();
   $error = NULL;
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      
      $sql = "SELECT username FROM users WHERE username = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
        
      if($count == 1) {
         $_SESSION['login_user'] = $myusername;
         $sql = "SELECT role FROM users WHERE username = '$myusername' and password = '$mypassword'";
         $result = mysqli_query($db,$sql);
         while($row = $result->fetch_assoc()) {
            $_SESSION['role'] = $row['role'];
         }

         header("location: index.php");
         exit();
         
      } else {
         $error = "Your Login Name or Password is invalid";
      }
   }
?>



<html>

	<head>

		<title>CSCB20 Log in</title>
		<link rel="stylesheet" type="text/css"
		href="index.css">

	</head>

	<body>



		<div class="loginbox">
		<img src="a3.png" class="avatar">
			<h1 id="logintitle">CSCB20 Website Login</h1>


	    	<form action = "" method = "post">
	    		
	        	<label>Username </label><br>
	        	<input type = "text" name = "username" class = "box" placeholder="Enter Username"/><br /><br />
	        	<label>Password </label><br>
	            <input type = "password" name = "password" class = "box" placeholder="Enter Password" /><br/><br />
	            <input id="submit" type = "submit" value = " Submit "/><br>
	            <a href="createacc.php">Create an account</a>
	            <div style = "font-size:11px; color:#cc0000; margin-top:0px"><?php echo $error; ?></div>

	       </form>

       </div>

	</body>




</html>
