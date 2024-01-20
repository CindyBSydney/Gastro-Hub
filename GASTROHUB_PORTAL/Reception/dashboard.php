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
	<meta http-equiv="refresh" content="10">

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
			<li class="active">
				<a href="dashboard.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="search.php">
					<i class='bx bx-search-alt' ></i>
					<span class="text">Search Patient</span>
				</a>
			</li>
			<li>
				<a href="register_patient.php">
                    <i class='bx bxs-edit' ></i>
					<span class="text">Register Patient</span>
				</a>
			</li>
			<li>
				<a href="my_profile.php">
					<i class='bx bx-user' ></i>
					<span class="text">My Profile</span>
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
					<h1>Reception</h1>
					<ul class="breadcrumb">
						<li>
							<a href="dashboard.php">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="">Home</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Triage Queue</h3>
					</div>
					<table>
						<thead>
                            <tr>
                                <th>Queue No.</th>
                                <th>Patient Name</th>
                                <th>Nurse Assigned</th>
                                <th>Status</th>
                            </tr>
						</thead>
						<tbody>
						<?php
							// Establish a database connection
							$servername = "localhost";
							$username = "root";
							$password = "";
							$dbname = "gastrohub_db";
							$conn = new mysqli($servername, $username, $password, $dbname);
							if ($conn->connect_error) {
								die("Connection failed: " . $conn->connect_error);
							}

							// Query all patients from tbl_patient_visit whose visit status is 1
							$sql = "SELECT * FROM tbl_patient_visit WHERE visit_status = '1' ORDER BY patient_visit_id LIMIT 5";
							$result = $conn->query($sql);
							$counter = 0;

							// Generate a row for each item
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									$counter++;
									// Get the triage_queue_number and patient_id
									$triage_queue_number = $row["triage_queue_number"];

									// If the number is less than 100, pad it with leading zeros to make it three digits long
									if ($triage_queue_number < 100) {
										$triage_queue_number = str_pad($triage_queue_number, 3, '0', STR_PAD_LEFT);
									}

									$patient_id = $row["patient_id"];

									// Use patient_id to get patient's full name from tbl_patient
									$sql2 = "SELECT * FROM tbl_patient WHERE patient_id = '$patient_id'";
									$result2 = $conn->query($sql2);

									// Generate a row for each item
									if ($result2->num_rows > 0) {
										while ($row2 = $result2->fetch_assoc()) {
											$first_name = $row2["first_name"];
											$last_name = $row2["last_name"];
											$patient_full_name = $first_name . " " . $last_name;
										}
									}

									// Assign a nurse to the patient randomly
									$sql3 = "SELECT * FROM tbl_user WHERE clearance_level_code = 'L4' ORDER BY RAND() LIMIT 1";
									$result3 = $conn->query($sql3);

									// Generate a row for each item
									if ($result3->num_rows > 0) {
										while ($row3 = $result3->fetch_assoc()) {
											$nurse_full_name = $row3["first_name"] . " " . $row3["last_name"];
											$is_available_num = $row3["is_available"];
											$processing = $row3["processing"];
										}
									}

									echo "<tr>";
									echo "<td style='text-align: center;'>" . $triage_queue_number . "</td>";
									echo "<td style='text-align: center;'>" . $patient_full_name . "</td>";
									echo "<td style='text-align: center;'>" . $nurse_full_name . "</td>";

									// Determine the status and color for the first row
									if ($counter === 1 && $is_available_num == 1 && $processing == 0) {
										echo "<td style='display:flex;align-items:center;justify-content:center;'><span disabled style='text-align:center;border:none;border-radius:10px;height:30px;width:200px;background-color: green;color:white;'>Room available</span></td>";
									} else if($counter === 1 && $is_available_num == 1 && $processing == 1){
										echo "<td style='display:flex;align-items:center;justify-content:center;'><span disabled style='text-align:center;border:none;border-radius:10px;height:30px;width:200px;background-color: orange;color:white;'>Triage Assessment</span></td>";
									} else {
										echo "<td style='display:flex;align-items:center;justify-content:center;'><span disabled style='text-align:center;border:none;border-radius:10px;height:30px;width:200px;background-color: red;color:white;'>Queued</span></td>";
									}
									
									echo "</tr>";
								}
							}

							// Close the database connection
							$conn->close();
						?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Consultation Queue</h3>
					</div>
					<table>
						<thead>
                            <tr>
                                <th>Queue No.</th>
                                <th>Patient Name</th>
                                <th>Oncologist Assigned</th>
                                <th>Status</th>
                            </tr>
						</thead>
						<tbody>
						<?php
							// Establish a database connection
							$servername = "localhost";
							$username = "root";
							$password = "";
							$dbname = "gastrohub_db";
							$conn = new mysqli($servername, $username, $password, $dbname);
							if ($conn->connect_error) {
								die("Connection failed: " . $conn->connect_error);
							}

							// Query all patients from tbl_patient_visit whose visit status is 2, 4, or 6
							$sql = "SELECT * FROM tbl_patient_visit WHERE visit_status = '2' OR visit_status = '4' OR visit_status = '6' ORDER BY patient_visit_id LIMIT 5";
							$result = $conn->query($sql);
							$counter = 0;
							$firstRow = true; // Keep track of the first row

							// Generate a row for each item
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									$counter++;
									// Get the oncologist_queue_number and patient_id
									$oncologist_queue_number = $row["oncologist_queue_number"];

									// If the number is less than 100, pad it with leading zeros to make it three digits long
									if ($oncologist_queue_number < 100) {
										$oncologist_queue_number = str_pad($oncologist_queue_number, 3, '0', STR_PAD_LEFT);
									}

									$patient_id = $row["patient_id"];

									// Use patient_id to get patient's full name from tbl_patient
									$sql2 = "SELECT * FROM tbl_patient WHERE patient_id = '$patient_id'";
									$result2 = $conn->query($sql2);

									// Generate a row for each item
									if ($result2->num_rows > 0) {
										while ($row2 = $result2->fetch_assoc()) {
											$first_name = $row2["first_name"];
											$last_name = $row2["last_name"];
											$patient_full_name = $first_name . " " . $last_name;
										}
									}

									// Assign an oncologist to the patient randomly
									$sql3 = "SELECT * FROM tbl_user WHERE clearance_level_code = 'L2' ORDER BY RAND() LIMIT 1";
									$result3 = $conn->query($sql3);

									// Generate a row for each item
									if ($result3->num_rows > 0) {
										while ($row3 = $result3->fetch_assoc()) {
											$radiologist_full_name = $row3["first_name"] . " " . $row3["last_name"];
											$is_available_num = $row3["is_available"];
											$processing = $row3["processing"];
										}
									}

									echo "<tr>";
									echo "<td style='text-align: center;'>" . $oncologist_queue_number . "</td>";
									echo "<td style='text-align: center;'>" . $patient_full_name . "</td>";
									echo "<td style='text-align: center;'>" . $radiologist_full_name . "</td>";

									// Determine the status and color for the first row
									if ($counter === 1 && $is_available_num == 1 && $processing == 0) {
										echo "<td style='display:flex;align-items:center;justify-content:center;'><span disabled style='text-align:center;border:none;border-radius:10px;height:30px;width:200px;background-color: green;color:white;'>Room available</span></td>";
									} else if($counter === 1 && $is_available_num == 1 && $processing == 1){
										echo "<td style='display:flex;align-items:center;justify-content:center;'><span disabled style='text-align:center;border:none;border-radius:10px;height:30px;width:200px;background-color: orange;color:white;'>Oncology Assessment</span></td>";
									} else {
										echo "<td style='display:flex;align-items:center;justify-content:center;'><span disabled style='text-align:center;border:none;border-radius:10px;height:30px;width:200px;background-color: red;color:white;'>Queued</span></td>";
									}

									echo "</tr>";

									// Set firstRow to false after processing the first row
									$firstRow = false;
								}
							}

							// Close the database connection
							$conn->close();
						?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Radiology Queue</h3>
					</div>
					<table>
						<thead>
                            <tr>
                                <th>Queue No.</th>
                                <th>Patient Name</th>
                                <th>Radiologist Assigned</th>
                                <th>Status</th>
                            </tr>
						</thead>
						<tbody>
						<?php
							// Establish a database connection
							$servername = "localhost";
							$username = "root";
							$password = "";
							$dbname = "gastrohub_db";
							$conn = new mysqli($servername, $username, $password, $dbname);
							if ($conn->connect_error) {
								die("Connection failed: " . $conn->connect_error);
							}

							// Query all patients from tbl_patient_visit whose visit status is 3 or 5
							$sql = "SELECT * FROM tbl_patient_visit WHERE visit_status = '3' OR visit_status = '5' ORDER BY patient_visit_id LIMIT 5";
							$result = $conn->query($sql);
							$counter = 0;
							$firstRow = true; // Keep track of the first row

							// Generate a row for each item
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									$counter++;
									// Get the radiologist_queue_number and patient_id
									$radiologist_queue_number = $row["radiologist_queue_number"];

									// If the number is less than 100, pad it with leading zeros to make it three digits long
									if ($radiologist_queue_number < 100) {
										$radiologist_queue_number = str_pad($radiologist_queue_number, 3, '0', STR_PAD_LEFT);
									}

									$patient_id = $row["patient_id"];

									// Use patient_id to get patient's full name from tbl_patient
									$sql2 = "SELECT * FROM tbl_patient WHERE patient_id = '$patient_id'";
									$result2 = $conn->query($sql2);

									// Generate a row for each item
									if ($result2->num_rows > 0) {
										while ($row2 = $result2->fetch_assoc()) {
											$first_name = $row2["first_name"];
											$last_name = $row2["last_name"];
											$patient_full_name = $first_name . " " . $last_name;
										}
									}

									// Assign a radiologist to the patient randomly
									$sql3 = "SELECT * FROM tbl_user WHERE clearance_level_code = 'L3' ORDER BY RAND() LIMIT 1";
									$result3 = $conn->query($sql3);

									// Generate a row for each item
									if ($result3->num_rows > 0) {
										while ($row3 = $result3->fetch_assoc()) {
											$radiologist_full_name = $row3["first_name"] . " " . $row3["last_name"];
											$is_available_num = $row3["is_available"];
											$processing = $row3["processing"];
										}
									}

									echo "<tr>";
									echo "<td style='text-align: center;'>" . $radiologist_queue_number . "</td>";
									echo "<td style='text-align: center;'>" . $patient_full_name . "</td>";
									echo "<td style='text-align: center;'>" . $radiologist_full_name . "</td>";

									// Determine the status and color for the first row
									if ($counter === 1 && $is_available_num == 1 && $processing == 0) {
										echo "<td style='display:flex;align-items:center;justify-content:center;'><span disabled style='text-align:center;border:none;border-radius:10px;height:30px;width:200px;background-color: green;color:white;'>Room available</span></td>";
									} else if($counter === 1 && $is_available_num == 1 && $processing == 1){
										echo "<td style='display:flex;align-items:center;justify-content:center;'><span disabled style='text-align:center;border:none;border-radius:10px;height:30px;width:200px;background-color: orange;color:white;'>Oncology Assessment</span></td>";
									} else {
										echo "<td style='display:flex;align-items:center;justify-content:center;'><span disabled style='text-align:center;border:none;border-radius:10px;height:30px;width:200px;background-color: red;color:white;'>Queued</span></td>";
									}

									echo "</tr>";

									// Set firstRow to false after processing the first row
									$firstRow = false;
								}
							}

							// Close the database connection
							$conn->close();
						?>
						</tbody>
					</table>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="../../templates/dash_script.js"></script>
</body>
</html>