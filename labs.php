<?php
    session_start();

    if(isset($_SESSION['login_user'])) {
		;

	} else {
		header("location: login.php");
		exit();
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

			<h1>CSCB20 Labs</h1>
			<hr>

			<h3>Week one:</h3>

			<ul>
				<li>Lab handout: <a href="#">lab one</a></li>
				<li>-Review of python</li>
				<li>-Basic loops, conditional statements, file IO etc</li>

			</ul>


			<h3>Week two:</h3>

			<ul>
				<li>Lab handout: <a href="#">lab two</a></li>
				<li>-Review of python</li>
				<li>-Basic loops, conditional statements, file IO etc</li>

			</ul>
			
			<h3>Week three:</h3>

			<ul>
				<li>Lab handout: <a href="#">lab three</a></li>
				<li>-Review of python</li>
				<li>-Basic loops, conditional statements, file IO etc</li>

			</ul>
			
			<h3>Week four:</h3>

			<ul>
				<li>Lab handout: <a href="#">lab four</a></li>
				<li>-Review of python</li>
				<li>-Basic loops, conditional statements, file IO etc</li>

			</ul>
			
			<h3>Week five:</h3>

			<ul>
				<li>Lab handout: <a href="#">lab five</a></li>
				<li>-Review of python</li>
				<li>-Basic loops, conditional statements, file IO etc</li>

			</ul>






		</div>


		<div id="nav2">
			<ul>

			</ul>

		</div>

		<h2><a href = "logout.php">Sign Out</a></h2>

	</body>


		<footer>
			<h3>Copyright</h3>
			Copyright &copy; 2018 Afzal Patel & Shaahid Sheth.<br>
			Faculty of Computer science <a href="http://www.utsc.utoronto.ca/cms/computer-science-1">here</a>

		</footer>


</html>

		