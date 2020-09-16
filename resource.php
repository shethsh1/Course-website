<?php
    include("config.php");
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

			<h1>Resources</h1>
			<hr>
			<h3>Many online resources:</h3>
			<hr>
			<ul>
				<li>The official course website <a href="index.html">here</a><br>
				Please check this website weekly to keep up with the course material</li>
				<li>A tutorial for SQL beginners <a href="https://code.tutsplus.com/articles/sql-for-beginners--net-8200"></a>here</li>
				<li>Question's about the course should be posted on piazza and/or email</li>
				<li>Link to piazza: <a href="https://piazza.com/class/jcpjjp5l4bywd?cid=202">piazza</a>

			</ul>
			<hr>
			<h3>Software Installation for CSCB20</h3>
			<hr>
			<p>1. Download MySQL Community edition on your computer from <a href="https://dev.mysql.com/downloads/mysql/">here</a> <br>

			

			During installation, a random password will be generated and presented to you as a dialog box. Make sure to save this!! You will use this later in SequelPro to connect to your database. <br><br>


			2 a). Download SequelPro from <a href="https://www.sequelpro.com">here</a> <br><br>

		
			2.b) If you are on Windows or Mac or Linux (you can use this 30 day trial version) <br><br>

			<a href="https://razorsql.com/download_win.html">razor sql</a> <br><br>

			From 2.a) and 2.b) you only require one of the other. You do not require both of them. If you want to use the command line or MySQLWorkBench these are also some other alternative. </p>




			

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

		