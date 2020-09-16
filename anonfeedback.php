<?php
	include("config.php");
    session_start();
    $error = NULL;
    $success = NULL;

	if(isset($_SESSION['login_user'])) {
		echo "Username: ".$_SESSION['login_user'];
		echo "<br>";
   		echo " Role: ".$_SESSION['role'];

	} else {
		header("location: login.php");
		exit();
	}
	if(strtolower($_SESSION['role']) != "student") {
		if(strtolower($_SESSION['role']) == "ta") {
			header("location: index.php");
			exit();
		} else if(strtolower($_SESSION['role']) == "instructor") {
			header("location: index.php");
			exit();
		}
	}


	if($_SERVER["REQUEST_METHOD"] == "POST") {

		if(empty($_POST['instructor'])) {
			$error = "There are no instructors in this course";
		} else if(empty($_POST['m1']) || strlen($_POST['m1']) < 10) {
			$error = "All fields arent answered or the length of one of them is under 10 character. 10+ please";
		} else if(empty($_POST['m2']) || strlen($_POST['m2']) < 10) {
			$error = "All fields arent answered or the length of one of them is under 10 character. 10+ please";
		} else if(empty($_POST['m3']) || strlen($_POST['m3']) < 10) {
			$error = "All fields arent answered or the length of one of them is under 10 character. 10+ please";
		} else if(empty($_POST['m4']) || strlen($_POST['m4']) < 10) {
			$error = "All fields arent answered or the length of one of them is under 10 character. 10+ please";
		} else if(empty($_POST['m5']) || strlen($_POST['m5']) < 10) {
			$error = "All fields arent answered or the length of one of them is under 10 character. 10+ please";
		} else if(empty($_POST['m6']) || strlen($_POST['m6']) < 10) {
			$error = "All fields arent answered or the length of one of them is under 10 character. 10+ please";
		} else {
			$instructors = mysqli_real_escape_string($db,$_POST['instructor']);
    		$m1 = mysqli_real_escape_string($db,$_POST['m1']);
       	 	$m2 = mysqli_real_escape_string($db,$_POST['m2']); 
        	$m3 = mysqli_real_escape_string($db,$_POST['m3']); 
        	$m4 = mysqli_real_escape_string($db,$_POST['m4']); 
        	$m5 = mysqli_real_escape_string($db,$_POST['m5']); 
        	$m6 = mysqli_real_escape_string($db,$_POST['m6']); 

        	$sql = "INSERT INTO feedback VALUES ('$instructors', '$m1', '$m2', '$m3', '$m4', '$m5', '$m6');";
        	$result = mysqli_query($db,$sql);
        	$success = "Sucessfully submitted feedback";

		}

	}
	   
?>





<html>
	<head>
		<title>anon feedback</title>
		<link rel="stylesheet" type="text/css"
		href="anon.css">
	</head>

	<body>
		<h4><a href = "logout.php">Sign Out</a></h4>
		<h4><a href= "index.php">Go back to the website</a></h4>

		<div class="container">

			<p>ANONYMOUS FEEDBACK</p>

			To give anonymous feedback to the instructor of this course, please fill out the form below. 
			Comment's are always nice to hear. Please do not use this form to ask questions about assignments, marks etc. For those refer to piazza and/or email. 
			<br><br>

			<form action = "" method = "post">
				<div style = "font-size:16px; color:green; margin-top:0px"><?php echo $success; ?></div>
				<div style = "font-size:16px; color:#cc0000; margin-top:0px"><?php echo $error; ?></div>
				<label>Choose Instructor: </label>
				<select id="instruct" name="instructor"> 
					<?php
						$sql = "SELECT DISTINCT username FROM users WHERE role='instructor'";
						$result = mysqli_query($db,$sql);
						while($row = $result->fetch_assoc()) {
					?>
					    	<option value="<?php echo $row['username'] ?>" ><?php echo $row['username']; ?></option>

					<?php } ?>
					
				</select>
				<br><br>

				What do you like about the instructor teaching? <br><br>

				<div class="msg">
					<textarea name="m1" class="area" placeholder="Leave a Message"></textarea>
				</div>

				What do you recommend the instructor to do to improve their teaching?<br><br>

				<div class="msg">
					<textarea name="m2" class="area" placeholder="Leave a Message"></textarea>
				</div>

				What do you like about the labs?<br><br>

				<div class="msg">
					<textarea name="m3" class="area" placeholder="Leave a Message"></textarea>
				</div>

				What do you recommend the lab instructors to do to improve their lab teaching?<br><br>

				<div class="msg">
					<textarea name="m4" class="area" placeholder="Leave a Message"></textarea>
				</div>

				What do you like best about this course? <br><br>

				<div class="msg">
					<textarea name="m5" class="area" placeholder="Leave a Message"></textarea>
				</div>


				What would you like to change about this course? <br><br>

				<div class="msg">
					<textarea name="m6" class="area" placeholder="Leave a Message"></textarea>
				</div>
				

				<div class="btn">
					<input type = "submit" value = " Submit " class="btn"/>
				</div>
				

			</form>

		</div>

	</body>

</html>