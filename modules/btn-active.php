<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>    
    <link rel="stylesheet" href="modules/sidebar.css">
    <title>Admin Landing Page</title>
</head>
<body>
    <section id="sidebar">
		<!--LOGO DIV-->
        <div class="container">
		<a href="#" class="LOGO"> 
			<img src="images/LOGO.png" class="image">
		</a>
        </div>
		<!--SIDE MENU-->
		<ul class="side-menu top" style="padding-left: 0px;">
			<li>
				<a href="admin_dashboard.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="resident.php">
					<i class='bx bxs-group' ></i>
					<span class="text">Residents List</span>
				</a>
			</li>
			<li class="active">
				<a href="index.php" id="calendar-btn">
					<i class='bx bxs-calendar'></i>
					<span class="text">Calendar</span>
				</a>
			</li>


			<li>
				<a href="sudden.php">
					<i class='bx bxs-megaphone' ></i>
					<span class="text">Announcements</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu" style="padding-left: 0px;">
		<li>
		<a href="archive.php">
					<i class='bx bxs-archive' ></i>
					<span class="text">Archive</span>
				</a>
			</li>
			<li>
				<a href="login.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!--JAVASCRIPT-->
	<script src="modules/sidebar.js"></script>
</body>

</html>

