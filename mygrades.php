<?php
	include("config.php");
	session_start();
	$error = NULL;
	$success = NULL;

   if(isset($_SESSION['login_user'])) {
	   ;

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



		if (empty($_POST['message']) || strlen($_POST['message']) > 1000) {
			$error = "Error: Please put a reason as to why you are remarking AND make sure it is 1000 characters or less, thank you.";

		} else if(empty($_POST['mark']) && $_POST['mark'] != 0) {
			$error = "There are currently no mark for this assignment";
		} else {
			$user = mysqli_real_escape_string($db,$_POST['username']);
		    $message = mysqli_real_escape_string($db,$_POST['message']); 
		    $assignment = mysqli_real_escape_string($db,$_POST['assignment']);
		    $ta = mysqli_real_escape_string($db,$_POST['TA']);

		    $sql = "SELECT remark FROM grades WHERE username='$user' AND assignmentName='$assignment' AND remark=true";
		    $result = mysqli_query($db,$sql);
		    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		    $count = mysqli_num_rows($result);

		    $sql = "SELECT remark FROM grades WHERE username='$user' AND assignmentName='$assignment' AND remark=true";
		    if($count==1) {
		    	$error = "Error: There is already a pending remark request for this assignment. Sorry, you must wait";
		    } else {
		    	if($ta == "Every TA") {
			    	$sql = "UPDATE grades SET remark=true WHERE username='$user' AND assignmentName = '$assignment'";
			    	$result = mysqli_query($db,$sql);
			    	$sql = "UPDATE grades SET description='$message' WHERE username='$user' AND assignmentName = '$assignment'";
			    	$result = mysqli_query($db,$sql);
			    	$success = "success";
				} else {
			    	$sql = "UPDATE grades SET remark=true WHERE username='$user' AND assignmentName = '$assignment'";
			    	$result = mysqli_query($db,$sql);
			    	$sql = "UPDATE grades SET description='$message' WHERE username='$user' AND assignmentName = '$assignment'";
			    	$result = mysqli_query($db,$sql);
			    	$sql = "UPDATE grades SET remarkTA ='$ta' WHERE username='$user' AND assignmentName = '$assignment'";
			    	$result = mysqli_query($db,$sql);
			    	$success = "success";
				}
		    }

		}

		
	}
	   


?>

<html>
	<head>
		<title>CSCB20 Winter 2018</title>
		<link rel="stylesheet" type="text/css"
		href="index_web.css">
		<script src="tabletoggler.js"></script>
	</head>

	<body>
		
		<header><h1>CSCB20 - Introduction to Databases and Web Applications</h1>
		<?php
		echo "Username: ".$_SESSION['login_user']; 
		echo '<br>';
		echo " Role: ".$_SESSION['role']; 
		?>
		</header>
		<nav>
				

			<ul>
				<li><a href="index.php">Home</a></li>
            	<li><a href="announcement.php">Announcements</a></li>
           		<li><a href="lectures.php">Lectures</a></li>
            	<li><a href="assignments.php">Assignments</a></li>
            	<li><a href="labs.php">Labs</a></li>
            	<li><a href="https://markus.utsc.utoronto.ca/cscb20w18/?locale=en">Markus</a></li>
           	 	<li><a href="https://piazza.com/class/jcpjjp5l4bywd?cid=15">Piazza</a></li>
          	 	<li><a href="tests.php">Tests</a></li>
          	 	<li><a href="courseteam.php">Course Team</a></li>
				<?php
					if(strtolower($_SESSION['role']) == "instructor") { 				
				?>
						<li><a href="instructorfeedback.php">Anon Feedback</a></li>
				<?php 
					} else if(strtolower($_SESSION['role']) == "student") {
				
				?>
						<li><a href="anonfeedback.php">Anon Feedback</a></li>
				<?php
					}
				?>
          	 	<li><a href="syllabus.php">Syllabus</a></li>
          	 	<li><a href="resource.php">Resources</a></li>

          	 	<?php
          	 		if(strtolower($_SESSION['role']) == "instructor") {
          	 	?>
          	 			<li><a href="instGrades.php">Display Student Grades</a></li>
          	 	<?php
          	 		}
          	 	?>

          	 	<?php
          	 		if(strtolower($_SESSION['role']) == "instructor" || strtolower($_SESSION['role']) == "ta") {
          	 	?>
					<li><a href="remarks.php">Display Remark Requests</a></li>
				<?php
					}
				?>

          	 	<?php
          	 		if(strtolower($_SESSION['role']) == "student") {
          	 	?>
					<li><a href="mygrades.php">click to see your grades</a></li>
				<?php
					}
				?>

				<?php
					if(strtolower($_SESSION['role']) == "student") {
						
				?>
						<li><a href="myrequest.php">Outstanding remark request</a></li>
				<?php

					}
				?>
				<li><a href = "logout.php">Sign Out</a></li>


			</ul>

		</nav>

		<div id="homeBody">

			<h1>Hello <?php echo $_SESSION['login_user']; ?></h1> <button id="toggle" onclick="toggletable()">Hide Tables</button>
      
	        <h2>Here are your grades</h2>  
	        <hr>

	        <div id="allTheTables">
      
	      		<div style = "font-size:30px; color:#cc0000; margin-top:0px"><?php echo $error; ?></div><br>
	      		<div style = "font-size:11px; color:green; margin-top:0px"><?php echo $success; ?></div><br>
				 <div class="divTable blueTable">
				    <div class="divTableHeading">
				        <div class="divTableRow">
				            <div class="divTableHead">Username</div>
				            <div class="divTableHead">Term Work / Exams</div>
				            <div class="divTableHead">Weight (%)</div>
				            <div class="divTableHead">Mark (%)</div>
				            <div class="divTableHead">submit remark?</div>
				        </div>
				    </div>
				    <div class="divTableBody">

				<?php
				    $theUser = $_SESSION['login_user'];
				    $sql = "SELECT username, assignmentName, assignmentWeight, mark FROM grades WHERE username='$theUser'";
				    $result = mysqli_query($db,$sql);
				    while($row = $result->fetch_assoc()) {
				?>
				        <div class="divTableRow">
				            <div class="divTableCell"><?php echo $row['username']; ?></div>
				            <div class="divTableCell"><?php echo $row['assignmentName']; ?></div>
				            <div class="divTableCell"><?php echo $row['assignmentWeight']; ?></div>
				            <div class="divTableCell"><?php echo $row['mark']; ?></div>
				            <form action = "" method = "post">
				            	<input type="hidden" name="username" value="<?php echo $row['username']; ?>"/>
				            	<input type="hidden" name="assignment" value="<?php echo $row['assignmentName']; ?>"/>
				            	<input type="hidden" name="mark" value="<?php echo $row['mark']; ?>"/>
					            <label>Description </label><br>
					            <textarea name="message" id="message" style="height: 150px;" placeholder="Enter text here..."></textarea><br>
					            <label>Choose TA: </label>

					            <select id="teacher" name="TA">
					            	<option value="Every TA">Every TA</option>
					            	<?php
									    $sql2 = "SELECT username FROM users WHERE role='ta'";
									    $result2 = mysqli_query($db,$sql2);
									    while($row2 = $result2->fetch_assoc()) {
					            	?>
					            			<option value="<?php echo $row2['username'] ?>" ><?php echo $row2['username']; ?></option>
					            	<?php

					            		} ?>
					            </select> 
					            <div class="divTableCell"><input type = "submit" value = " Submit "/><br></div>

					            
				            </form>
				        </div>

				<?php } ?>
				    </div>
				</div>


			</div>

		</div>

		<div id="nav2">
			<ul>

			</ul>

		</div>

		<script src="tabletoggler.js"></script>







	</body>


		<footer>
			<h3>Copyright</h3>
			Copyright &copy; 2018 Afzal Patel & Shaahid Sheth.<br>
			Faculty of Computer science <a href="http://www.utsc.utoronto.ca/cms/computer-science-1">here</a>

		</footer>


</html>

		
