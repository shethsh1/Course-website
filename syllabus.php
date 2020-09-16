<?php
    session_start();

    if(isset($_SESSION['login_user'])) {
		;

	} else {
		header("location: syllabus.php");
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

			<h1>Introduction to Databases and Web Applications – Winter 2018</h1>
			<hr>

			<strong>Course Description</strong><br>
			<p>A practical introduction to databases and Web app development. Databases: terminology and applications; creating,querying and updating databases; the entity-relationship model for database design. Web documents andapplications: static and interactive documents; Web servers and dynamic server-generated content; Web application development and interface with databases.</p>

			<strong>Required background</strong><br>
			<p>Some experience with programming in an imperative language such as Python, Java or C. This course may not be
			taken after - or concurrently with - any C- or D-level CSC course.</p>

			<strong>Course Information & Schedule</strong><br>
			<ul>
				
				<li>Instructor: A. Attarwala</li>
				<li>Lecture: Mondays 9am to 11am in SW 319</li>
				<li>Tutorials: Check Online Schedule</li>
				<li>Email: MYFIRSYNAME.MYLASTNAME@utoronto.ca</li>

			</ul>


			<strong>Text Books</strong><br>
			<ul>
				<li>There is no required textbook, however, mandatory readings will be assigned using various web pages from the internet.</li>
			</ul>


			<strong>Lecture Notes</strong><br>
			<ul>
				<li>Lecture notes will be available on Blackboard. You are EXPECTED to read the assigned readings before coming to lecture.</li>
			</ul>

			<strong>Grading Scheme and Policies</strong><br>

			<p><strong>Assignments</strong>: 30% (Total of three assignments)</p>
			<p><strong>Practical</strong>: 5% (End of semester for tutorials)</p>
			<p><strong>Midterm Exam</strong>: 15% (TBD)</p>
			<p><strong>Quizzes</strong>: 10% (Three quizzes)</p>
			<p><strong>Final Exam</strong>: 40% (TBD)</p>

			<div class="rubric">

				<div class="our_row">
					<div class="our_cell">Assignment #:</div>
					<div class="our_cell">Assignment 1</div>
					<div class="our_cell">Assignment 2</div>
					<div class="our_cell">Assignment 3</div>
				</div>


				<div class="our_row">
					<div class="our_cell">Weight: </div>
					<div class="our_cell">10%</div>
					<div class="our_cell">10%</div>
					<div class="our_cell">10%</div>
				</div>

				<div class="our_row">
					<div class="our_cell">Date: </div>
					<div class="our_cell">01/01/2018</div>
					<div class="our_cell">02/01/2018</div>
					<div class="our_cell">03/01/2018</div>
				</div>

			</div>


			<div class="rubric">

				<div class="our_row">
					<div class="our_cell">Quiz #:</div>
					<div class="our_cell">Quiz 1</div>
					<div class="our_cell">Quiz 2</div>
					<div class="our_cell">Quiz 3</div>
				</div>


				<div class="our_row">
					<div class="our_cell">Weight: </div>
					<div class="our_cell">3%</div>
					<div class="our_cell">4%</div>
					<div class="our_cell">3%</div>
				</div>

				<div class="our_row">
					<div class="our_cell">Date: </div>
					<div class="our_cell">01/01/2018</div>
					<div class="our_cell">02/01/2018</div>
					<div class="our_cell">03/01/2018</div>
				</div>

			</div>


			<strong>Assignments</strong><br>
			<p>There are three assignments. You may be asked to work in pairs in some of these assignments. Please check the assignment handout for these details for the exact due date and whether you can work in groups or not. DO NOT EMAIL YOUR ASSIGNMENTS TO US. We will use MARKUS for the submission of all assignments. ALL ASSIGNMENTS WILL MARKED ON UTSC LAB MACHINES. IT IS IMPORTANT BEFORE SUBMITTING YOUR ASSIGNMENT, TO MAKE SURE THAT IT COMPILES AND EXECUTES ON THE UTSC LAB MACHINES. A STRICT silent policy takes effect 12 hours before an ASSIGNMENT or EXAM is due. This means no question about the assignment will be answered by instructor or the TA whether it is asked on the bulletin board, by email or in person. </p>

			<strong>Remarks</strong><br>
			<p>If a piece of work has been mis-marked or if you believe the rubric used to evaluate the work is not appropriate, you may request a re-mark. For a re-mark to succeed, you must clearly and concisely express what you believe was mis-marked or unfairly marked. To request a re-mark, set up an appointment with the instructor and the TA that has marked your assignment/exam. PLEASE DO NOT USE THE DISCUSSION BOARD REQUESTING FOR REMARKS. Be prepared for the entire work to be re-evaluated and for the mark to be adjusted up or down after the re-evaluation. Remark request MUST be made in 5 regular days time after the mark is made available. No remark request will be accepted after 5 regular days.</p>

			<strong>Labs</strong><br>
			<p>During Labs, attendance is mandatory and on some occasions the TA will take attendance and assign you small in lab exercises. Labs are a great way for you to get some hands-on practice at programming</p>

			<strong>Final Exam</strong><br>
			<p>There is a 3hrs final exam. The final exam is comprehensive, and you must obtain a mark of at least 40% to pass the course; otherwise, a grade of no higher than 47% will be assigned.</p>


			<strong>Late Policy</strong><br>
			<p>There are no grace days; all due dates are firm. In case of illness, please have a doctor complete an official U of T medical certificate. For other emergencies, be prepared for us to request some kind of documentation. If you submit an assignment late or miss a midterm test due to illness or personal issue, first contact the instructor as soon as possible. Then, please follow the procedure described at https://www.utsc.utoronto.ca/aacc/petitions. For course work petitions, a Petition Form for Term Work form needs to be filled and given to the course instructor. This will not be accepted if submitted two days after the due date.</p>



			<p><strong>Plagiarism and cheating will not be tolerated.</strong> These are serious academic offences with severe consequences that you should be aware of; for details, please read the information in Chapter 6: Academic Regulations available at http://www.utsc.utoronto.ca/aacc/academic-integrity . You can also visit http://www.utsc.utoronto.ca/aacc/academic-integrity. If you any questions about cheating or plagiarism, ask your instructor.</p>

			<strong>Accessibility Needs</strong><br>

			<p>The University of Toronto is committed to accessibility. If you require accommodations for a disability, or have any accessibility concerns about the course, the classroom or course materials, please contact Accessibility Services as soon as possible: disability.services@utoronto.ca or http://www.utsc.utoronto.ca/~ability/.</p>

			<strong>Rough Semester Plan </strong><br>

			<ul>
				<li>Databases: Terminology and applications,Creating, querying and updating databases, The E-R model fordatabase design</li>
				<li>Web Applications: Static and Interactive Documents, Web servers and dynamic server-generated content; Web application development and integration with databases.</li>
			</ul>

			<p>Alternative syllabus in pdf: <a href="http://www.utsc.utoronto.ca/~bretscher/b20/syllabus.pdf">syllabus</a></p>

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

		