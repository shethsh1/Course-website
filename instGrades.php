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
   if(strtolower($_SESSION['role']) != "instructor") {
	   if(strtolower($_SESSION['role']) == "ta") {
		   header("location: index.php");
		   exit();
	   } else if(strtolower($_SESSION['role']) == "student") {
		   header("location: index.php");
		   exit();
	   }
	}


	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form1'])) {
  		if (empty($_POST["username"])) {
    		$error = "username is required";
    	} else if(empty($_POST["mark"]) && $_POST["mark"] != 0) {
    		$error = "mark is required";
    	}
    	$user = mysqli_real_escape_string($db,$_POST['username']);
        $mark = mysqli_real_escape_string($db,$_POST['mark']); 
        $work = mysqli_real_escape_string($db,$_POST['termwork']); 

        $sql = "SELECT DISTINCT username FROM grades WHERE username = '$user'";
        $result = mysqli_query($db,$sql);
        
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
        if($count != 1) {
        	$error = "username not in grades table";
        } else if(!(is_numeric($mark))) {
        	$error = "mark must be 0 to 100. E.g. 10, 20, 40, etc";
        } else {
        	$mark = floatval($mark);
        	if($mark > 100 || $mark < 0) {
        		$error = "mark must be 0 to 100. E.g. 10, 20, 40, etc";
        	}
        	$sql = "UPDATE grades SET mark=$mark WHERE username='$user' AND assignmentName = '$work'";
        	$result = mysqli_query($db,$sql);
        	$success = "Successfully added grade";
        	

        }
        
	}

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form2'])) {
        if(empty($_POST['aname'])) {
        	$error = "Please write a name for the assignment";
        } else if(empty($_POST['weight']) && $_POST["weight"] != 0) {
        	$error = "Please specify a weight for the assignment";
        } else if(!(is_numeric($_POST['weight']))) {
        	$error = "Weight must be a number from 0 to 100";
        } else {
    		$aname = mysqli_real_escape_string($db,$_POST['aname']);
        	$weight = mysqli_real_escape_string($db,$_POST['weight']); 
        	$weight = floatval($weight);
        	$sql = "SELECT username FROM grades;";
        	$result = mysqli_query($db, $sql);
      		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      		$count = mysqli_num_rows($result);
      		if($count == 0) {
      			$sql = "SELECT DISTINCT username FROM users WHERE role='student'";
	        	$result = mysqli_query($db, $sql);
	      		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	      		$count = mysqli_num_rows($result);
	      		if($count == 0) {
	      			$error = "Sorry but you must have atleast one student to insert an assignment";
	      		} else {
	      			$sql = "SELECT DISTINCT username FROM users WHERE role='student'";
		        	$result = mysqli_query($db, $sql);
	      			while($row = $result->fetch_assoc()) {
	      				$thisUser = $row['username'];
	      				$sql2 = "INSERT INTO grades VALUES ('$thisUser', '$aname', '$weight', NULL, false, NULL, NULL);";
	      				$result2 = mysqli_query($db, $sql2);
	      			}
	      			$success = "Successfully added term work";
	      		}

      		} else {
      			$sql = "SELECT DISTINCT assignmentName FROM grades WHERE assignmentName = '$aname'";
      			$result = mysqli_query($db, $sql);
      			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      			$count = mysqli_num_rows($result);
      			if($count != 0) {
      				$error = "Assignment name already exist please choose another";
      			} else {
	      			$sql = "SELECT DISTINCT username FROM grades;";
	      			$result = mysqli_query($db, $sql);
	      			while($row = $result->fetch_assoc()) {
	      				$thisUser = $row['username'];
	      				$sql2 = "INSERT INTO grades VALUES ('$thisUser', '$aname', '$weight', NULL, false, NULL, NULL);";
	      				$result2 = mysqli_query($db, $sql2);
	      			}
	      			$success = "Successfully added term work";
	      		}
      		}

        }
        	
        
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form3'])) {
    	if(empty($_POST['dname'])) {
    		$error = "Assignment field must be filled in";
    	} else {
    		$dname = mysqli_real_escape_string($db,$_POST['dname']);
    		$sql = "SELECT assignmentName FROM grades WHERE assignmentName = '$dname';";
    		$result = mysqli_query($db, $sql);
      		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      		$count = mysqli_num_rows($result);
      		if($count == 0) {
      			$error = "Assignment not in grades table";
      		} else {
	      		$sql = "DELETE FROM grades WHERE assignmentName = '$dname';";
	      		$result = mysqli_query($db, $sql);
	      		$success = "Successfully deleted assignment";

      		}
    		
    	}

    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form4'])) {
        if(empty($_POST['aname'])) {
        	$error = "Please write a name for the assignment";
		} else if(empty($_POST['weight']) && $_POST["weight"] != 0) {
        	$error = "Please specify a weight for the assignment";
        } else if(!(is_numeric($_POST['weight']))) {
        	$error = "Weight must be a number from 0 to 100";
        } else {
    		$aname = mysqli_real_escape_string($db,$_POST['aname']);
        	$weight = mysqli_real_escape_string($db,$_POST['weight']); 
        	$weight = floatval($weight);
        	$sql = "SELECT DISTINCT assignmentName FROM grades WHERE assignmentName = '$aname';";
      		$result = mysqli_query($db, $sql);
      		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      		$count = mysqli_num_rows($result);
      		if($count != 1) {
      			$error = "Assignment does not exist";
      		} else if($weight > 100 || $weight < 0) {
      			$error = "weight must be an integer between 100 to 0";
      		} else {
      			$sql = "UPDATE grades SET assignmentWeight=$weight WHERE assignmentName = '$aname';";
      			$result = mysqli_query($db, $sql);
      			$success = "Successfully added new weight to existing assignment";
      			


      			
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

			<h1>CSCB20 Student Grades</h1> <button id="toggle" onclick="toggletable()">Hide Tables</button>

			<div style = "font-size:20px; color:#cc0000; margin-top:0px"><?php echo $error; ?></div>
		    <div style = "font-size:20px; color:green; margin-top:0px"><?php echo $success; ?></div>
      
	        <h2>Entire Grades</h2>
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
				        </div>
				    </div>
				    <div class="divTableBody">

				<?php
				    
				    $sql = "SELECT username, assignmentName, assignmentWeight, mark, remark  FROM grades";
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
				        </div>

				<?php } ?>
				    </div>
				</div>
			<!-- DivTable.com --> 
			</div>
	        
			<div class="gradesForm">
				<h3 id="logintitle">Adjust grades</h3>
				<hr>


		    	<form action = "" method = "post">
		    		
		        	<label>Student's username </label><br>
		        	<input type = "text" name = "username" class = "box" placeholder="Enter Username"/><br><br>
		        	<label>Choose work to edit </label>
		        	<select id="allwork" name="termwork"> 
				    	<?php
							$sql = "SELECT DISTINCT assignmentName FROM grades";
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


	       <div class="AssignmentForm">

		       <h3 id="logintitle">Create Term Work</h3>
		       <hr>


		    	<form action = "" method = "post">
		    		
		        	<label>Name of Assignment</label><br>
		        	<input type = "text" name = "aname" class = "box" placeholder="Enter Assignment Name"/><br><br>
		        	<label>Choose weight</label><br>
		        	<input type = "text" name = "weight" class = "box" placeholder="Enter Weight"/><br><br>
		            <input type = "submit" name="form2" value = " Submit "/><br>

		            
		            

		       </form>



	       </div>

	       <div class="DeleteAssignmentForm">

		       <h3>Delete Term Work</h3>
		       <hr>


		    	<form action = "" method = "post">
		    		
		        	<label>Name of assignment to delete</label><br>
		        	<input type = "text" name = "dname" class = "box" placeholder="Enter Assignment Name"/><br><br>
		            <input type = "submit" name="form3" value = " Submit "/><br>
		            
		           
		       </form>



	       </div>

	       <div class="AdjustWeight">

		       <h3>Adjust Weight</h3>
		       <hr>


		    	<form action = "" method = "post">
		    		
		        	<label>Name of assignment to change</label><br>
		        	<input type = "text" name = "aname" class = "box" placeholder="Enter Assignment Name"/><br><br>
		        	<label>Changed Weight</label><br>
		        	<input type = "text" name = "weight" class = "box" placeholder="Enter Weight"/><br><br>
		            <input type = "submit" name="form4" value = " Submit "/><br>
		            
		           
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

		
