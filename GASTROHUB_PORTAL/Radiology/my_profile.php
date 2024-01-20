<?php
    include_once '../../AUTH/connection.php';
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT first_name FROM tbl_user WHERE user_id = '$user_id'";
    $result = getData($sql);
    $first_name = $result['first_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="../../CSS/dash_style.css">

	<title>GastroHub Portal</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="dashboard.php" class="brand">
			<i class='bx bx-plus-medical'></i>
			<span class="text">GastroHub</span>
		</a>
		<ul class="side-menu top">
			<li>
				<a href="dashboard.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="search.php">
					<i class='bx bx-search-alt' ></i>
					<span class="text">Search</span>
				</a>
			</li>
			<li class="active">
				<a href="my_profile.php">
					<i class='bx bx-user' ></i>
					<span class="text">My Profile</span>
				</a>
			</li>
			<li>
				<a href="my_books.php">
                    <i class='bx bxs-book-open' ></i>
					<span class="text">Consultation</span>
				</a>
			</li>
            <li>
				<a href="my_history.php">
					<i class='bx bx-vial' ></i>
					<span class="text">Cancer Results</span>
				</a>
			</li>
            <li>
				<a href="my_penalties.php">
					<i class='bx bx-dna' ></i>
					<span class="text">MSI/MSS Results</span>
				</a>
			</li>
			<li>
				<a href="../../AUTH/logout.php" class="logout">
					<i class='bx bx-exit' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu'></i>
            <h2 class="profile">
                <?php
                    $midnight = new DateTime('today');
                    $currentDateTime = new DateTime();
                    $interval = $midnight->diff($currentDateTime);
                    $hoursPassed = $interval->h;

                    if($hoursPassed >= 0 && $hoursPassed < 12){
                        echo("<a>Good morning, ");
                    } else if($hoursPassed >= 12 && $hoursPassed < 18){
                        echo("<a>Good afternoon, ");
                    } else if($hoursPassed >= 18 && $hoursPassed < 24){
                        echo("<a>Good evening, ");
                    }
                    echo($first_name."</a>");
                ?>
			</h2>
			<!-- <form>
				<div class="form-input">
					<input type="search" placeholder="Search..." hidden>
					<button type="submit" class="search-btn" style="background-color:transparent;"><i class='bx bx-search' hidden></i></button>
				</div>
			</form>
            <a>Change Theme</a>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <div id="theme-icon-container" style="display:flex;align-items:center;justify-content:center;position:relative;width:30px;height:30px;border-radius:50%;">
                <i class="bx bx-sun" id="sun-icon" style="color:yellow;"></i>
                <i class="bx bx-moon" id="moon-icon" style="color:grey;"></i>
            </div> -->
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Radiology</h1>
					<ul class="breadcrumb">
						<li>
							<a href="dashboard.php">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="">My Profile</a>
						</li>
					</ul>
				</div>
			</div>


			<div class="table-data">
				<div class="todo">
					<div class="head">
						<h3>Profile Details</h3>
					</div>
                    <?php
                        include_once '../../AUTH/connection.php';
                        $user_id = $_SESSION['user_id'];
                        // Establish a database connection
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "gastrohub_db";
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Query all items from tbl_library_item
                        $sql = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
                        $result = $conn->query($sql);
                        $counter = 0;

                        // Generate a row for each item
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $first_name = $row['first_name'];
                                $last_name = $row['last_name'];
                                $email = $row['email'];
                            }
                        }

                        // Close the database connection
                        $conn->close();
                    ?>
					<ul class="todo-list">
						<li class="completed">
                            <p><?php echo "First Name:&emsp;<text style='font-weight:bold;'>" . $first_name; ?></text></p>
						</li>
                        <li class="not-completed">
                            <p><?php echo "Last Name:&emsp;<text style='font-weight:bold;'>" . $last_name; ?></text></p>
						</li>
                        <li class="completed">
                            <p><?php echo "Email:&emsp;<text style='font-weight:bold;'>" . $email; ?></text></p>
						</li>
					</ul>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="../../templates/dash_script.js"></script>
</body>
</html>