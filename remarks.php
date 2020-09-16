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
    if(strtolower($_SESSION['role']) != "instructor" || strtolower($_SESSION['role']) != "ta") {
		if(strtolower($_SESSION['role']) == "student") {
			header("location: index.php");
			exit();
		}
	}


	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form1'])) {
  		if (empty($_POST["username"])) {
    		$error = "username is required";
    	} else if(empty($_POST["mark"]) && $_POST["mark"] != 0) {
    		$error = "mark is required";
    	} else if(empty($_POST["termwork"])) {
    		$error = "Assignment field cannot be empty";
    	} else {
	    	$user = mysqli_real_escape_string($db,$_POST['username']);
	        $mark = mysqli_real_escape_string($db,$_POST['mark']); 
	        $work = mysqli_real_escape_string($db,$_POST['termwork']); 

	        $sql = "SELECT DISTINCT username FROM grades WHERE username = '$user' and remark=true";
	        $result = mysqli_query($db,$sql);
	        
	        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	        $count = mysqli_num_rows($result);
	        if($count != 1) {
	        	$error = "username not in grades table";
	        } else if (!(is_numeric($mark))) {
	        	$error = "mark must be 0 to 100. E.g. 10, 20, 40, etc";
	        } else {
	        	$mark = floatval($mark);
	        	if($mark > 100 || $mark < 0) {
	        		$error = "mark must be 0 to 100. E.g. 10, 20, 40, etc";
	        	} else {
		        	$sql = "UPDATE grades SET mark=$mark WHERE username='$user' AND assignmentName = '$work' AND remark=true;";
		        	$result = mysqli_query($db,$sql);
		        	$sql = "UPDATE grades SET remark=false WHERE username='$user' AND assignmentName = '$work';";
		        	$result = mysqli_query($db,$sql);
		        	$sql = "UPDATE grades SET remarkTA=NULL WHERE username='$user' AND assignmentName = '$work';";
		        	$result = mysqli_query($db,$sql);
		        	$sql = "UPDATE grades SET description=NULL WHERE username='$user' AND assignmentName = '$work';";
		        	$result = mysqli_query($db,$sql);
		        	$success = "Successfully added grade";
		        }
	        	

	        }
	    }
        
	}

	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form2'])) {
		if(empty($_POST['username'])) {
			$error = "Username field cannot be empty";
		} else if(empty($_POST['termwork'])) {
			$error = "Assignment field cannot be empty";
		} else {
		    $user = mysqli_real_escape_string($db,$_POST['username']);
		    $work = mysqli_real_escape_string($db,$_POST['termwork']); 
		    $sql = "SELECT username FROM grades WHERE username='$user' AND remark=true AND assignmentName = '$work';";
		    $result = mysqli_query($db, $sql);
		    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		    $count = mysqli_num_rows($result);
		    if($count != 1) {
		    	$error = "Username with assignment remark request not found";
		    } else {
		    	$sql = "UPDATE grades SET remark=false WHERE username='$user' AND assignmentName = '$work';";
		    	$result = mysqli_query($db, $sql);
		    	$sql = "UPDATE grades SET description=NULL WHERE username='$user' AND assignmentName = '$work';";
		    	$result = mysqli_query($db, $sql);
		    	$sql = "UPDATE grades SET remarkTA=NULL WHERE username='$user' AND assignmentName = '$work';";
		    	$result = mysqli_query($db, $sql);
		    	$success = "Successfully denied request";
		    }
			
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

			<h1>CSCB20 Grades with remark request</h1> <button id="toggle" onclick="toggletable()">Hide Tables</button>

			<div style = "font-size:16px; color:#cc0000; margin-top:0px"><?php echo $error; ?></div>
		    <div style = "font-size:16px; color:green; margin-top:0px"><?php echo $success; ?></div>
      
	        <h2>Remark Request</h2>
	        <hr>

	        <div id="allTheTables">

				 <div class="divTable blueTable">
				    <div class="divTableHeading">
				        <div class="divTableRow">
				            <div class="divTableHead">Username</div>
				            <div class="divTableHead">Term Work / Exams</div>
				            <div class="divTableHead">Weight (%)</div>
				            <div class="divTableHead">Mark (%)</div>
				            <div class="divTableHead">Remark Request</div>
				            <div class="divTableHead">Description of request</div>
				        </div>
				    </div>
				    <div class="divTableBody">

				<?php
				    $currUser = $_SESSION['role'];
				    $theUser = $_SESSION['login_user'];
				    if(strtolower($currUser) == "instructor") {
				    	$sql = "SELECT username, assignmentName, assignmentWeight, mark, description, remark FROM grades WHERE remark = true;";
				    } else {
				    	$sql = "SELECT username, assignmentName, assignmentWeight, mark, description, remark FROM grades WHERE remark = true and(remarkTA = '$theUser' or remarkTA is NULL);";
				    }
				    $result = mysqli_query($db,$sql);
				    while($row = $result->fetch_assoc()) {
				?>
				        <div class="divTableRow">
				            <div class="divTableCell"><?php echo $row['username']; ?></div>
				            <div class="divTableCell"><?php echo $row['assignmentName']; ?></div>
				            <div class="divTableCell"><?php echo $row['assignmentWeight']; ?></div>
				            <div class="divTableCell"><?php echo $row['mark']; ?></div>
				            

				            <?php 

					            $output = NULL;
					            if($row['remark'] == FALSE) {
					            	$output = "FALSE";
								} else {
									$output = "TRUE";
								}
				            	
				            ?>
				            <div class="divTableCell"><?php echo $output; ?></div>
				            <div class="divTableCell"><?php echo $row['description']; ?></div>
				        </div>

				<?php } ?>
				    </div>
				</div>
				<!-- DivTable.com -->
		        
				<div class="gradesForm">
					<h3 id="logintitle">Adjust grades</h3>
					<hr>


			    	<form action = "" method = "post">
			    		
			        	<label>Student's username </label><br>
			        	<input type = "text" name = "username" class = "box" placeholder="Enter Username"/><br><br>
			        	<label>Choose work to edit </label>
			        	<select id="allwork" name="termwork"> 
					    	<?php
								$sql = "SELECT DISTINCT assignmentName FROM grades WHERE remark=true";
							    $result = mysqli_query($db,$sql);
							    while($row = $result->fetch_assoc()) {
					    	?>
					            	<option value="<?php echo $row['assignmentName'] ?>" ><?php echo $row['assignmentName']; ?></option>

					        <?php } ?>
			        	</select><br><br>

			        	<label>Mark </label><br>
			            <input type = "text" name = "mark" class = "box" placeholder="Enter mark" /><br/><br />
			            <input type = "submit" name="form1" value = " Submit "/><br>
			            
			            

			       </form>


			      
		       </div> 

	       </div>


			<div class="gradesForm">
				<h3>Cancel remark request</h3>
				<hr>


		    	<form action = "" method = "post">
		    		
		        	<label>Student's username</label><br>
		        	<input type = "text" name = "username" class = "box" placeholder="Enter Username"/><br><br>
		        	<label>Choose assignment</label>
		        	<select id="allwork" name="termwork"> 
				    	<?php
							$sql = "SELECT DISTINCT assignmentName FROM grades WHERE remark=true";
						    $result = mysqli_query($db,$sql);
						    while($row = $result->fetch_assoc()) {
				    	?>
				            	<option value="<?php echo $row['assignmentName'] ?>" ><?php echo $row['assignmentName']; ?></option>

				        <?php } ?>
		        	</select><br><br>
		            <input type = "submit" name="form2" value = " Submit "/><br>
		            
		            

		       </form>


		      
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

		
