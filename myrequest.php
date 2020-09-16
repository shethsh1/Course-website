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


	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form1'])) {
		if(empty($_POST['assignment'])) {
			$error = "No remark request";
		} else {
			$work = mysqli_real_escape_string($db,$_POST['assignment']);
			$theUser = $_SESSION['login_user'];
			$sql = "UPDATE grades SET remark = false WHERE username='$theUser' AND assignmentName = '$work'";
			$result = mysqli_query($db, $sql);
			$sql = "UPDATE grades SET remarkTA=NULL WHERE username='$theUser' AND assignmentName = '$work'";
			$result = mysqli_query($db, $sql);
			$sql = "UPDATE grades SET description=NULL WHERE username='$theUser' AND assignmentName = '$work'";
			$result = mysqli_query($db, $sql);
			$success = "Successfully removed remark request";

		}


	}

	  

?>

<html>
	<head>
		<title>CSCB20 Winter 2018</title>
		<link rel="stylesheet" type="text/css"
		href="index_web.css">
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

			<h1>Hello <?php echo $_SESSION['login_user']; ?></h1>
      
	        <h2>Here are your remark request</h2>
	        <hr>
      
      		<div style = "font-size:30px; color:#cc0000; margin-top:0px"><?php echo $error; ?></div><br>
      		<div style = "font-size:30px; color:green; margin-top:0px"><?php echo $success; ?></div><br>
			 <div class="divTable blueTable">
			    <div class="divTableHeading">
			        <div class="divTableRow">
			            <div class="divTableHead">Term Work / Exams</div>
			            <div class="divTableHead">Description</div>
			        </div>
			    </div>
			    <div class="divTableBody">

			<?php
			    $theUser = $_SESSION['login_user'];
			    $sql = "SELECT assignmentName, description FROM grades WHERE username='$theUser' AND remark=true;";
			    $result = mysqli_query($db,$sql);
			    while($row = $result->fetch_assoc()) {
			?>
			        <div class="divTableRow">
			            <div class="divTableCell"><?php echo $row['assignmentName']; ?></div>
			            <div class="divTableCell"><?php echo $row['description']; ?></div>
			        </div>

			<?php } ?>
			    </div>
			</div>


			<h3>Cancel a remark request?</h3>
			<hr>

			<form action="" method="post">
				<label>Assignment Name</label>
				<select id="work" name="assignment">
				     <?php
				     		$myUser = $_SESSION['login_user'];
							$sql = "SELECT assignmentName FROM grades WHERE username='$myUser' AND remark=true;";
							$result = mysqli_query($db,$sql);
							while($row = $result->fetch_assoc()) {
				     ?>
				            	<option value="<?php echo $row['assignmentName'] ?>" ><?php echo $row['assignmentName']; ?></option>
				     <?php

				      		} 
				     ?>
				</select> 
				<br><br>
				<input type = "submit" name = "form1" value = " Submit "/>


			</form>


		</div>

		<div id="nav2">
			<ul>

			</ul>

		</div>





	</body>


		<footer>
			<h3>Copyright</h3>
			Copyright &copy; 2018 Afzal Patel & Shaahid Sheth.<br>
			Faculty of Computer science <a href="http://www.utsc.utoronto.ca/cms/computer-science-1">here</a>

		</footer>


</html>

		
