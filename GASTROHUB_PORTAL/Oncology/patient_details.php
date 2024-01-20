<?php
    include_once '../../AUTH/connection.php';
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT first_name FROM tbl_user WHERE user_id = '$user_id'";
    $result = getData($sql);
    $first_name = $result['first_name'];

    // Get the patient_id from the GET
    $patient_id = $_GET['patient_id'];
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
				<a href="">
					<i class='bx bxs-notepad' ></i>
					<span class="text">Patient Details</span>
				</a>
			</li>
			<li>
				<a href="my_profile.php">
					<i class='bx bx-user' ></i>
					<span class="text">My Profile</span>
				</a>
			</li>
			<li>
				<a href="consultation.php?patient_id=<?php echo($patient_id); ?>">
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
					<h1>Oncology</h1>
					<ul class="breadcrumb">
						<li>
							<a href="dashboard.php">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="">Patient Details</a>
						</li>
					</ul>
				</div>
			</div>

            <div class="table-data">
				<div class="todo">
					<div class="head">
						<h3>Patient Details</h3>
					</div>
                    <?php
                        // Query the tbl_patient
                        $sql = "SELECT * FROM tbl_patient WHERE patient_id = '$patient_id'";
                        $result = getData($sql);
                        $first_name = $result["first_name"];
                        $last_name = $result["last_name"];
                        $patient_full_name = $first_name . " " . $last_name;
                        $dob = $result["dob"];
                        $dobDateTime = DateTime::createFromFormat('d/m/Y', $dob);
                        $currentDate = new DateTime();
                        $ageInterval = $currentDate->diff($dobDateTime);
                        $age = $ageInterval->y;

                        // Query the tbl_triage
                        $sql = "SELECT * FROM tbl_triage WHERE patient_id = '$patient_id' ORDER BY triage_record_id DESC LIMIT 1";
                        $result = getData($sql);
                        $blood_type = $result["blood_type"];
                        $height = $result["height"];
                        $weight = $result["weight"];
                        $blood_pressure_systolic = $result["blood_pressure_systolic"];
                        $blood_pressure_diastolic = $result["blood_pressure_diastolic"];
                        $temperature = $result["temperature"];
                        $signs_and_symptoms = $result["signs_and_symptoms"];
                    ?>
					<ul class="todo-list">
						<li class="completed">
                            <p><?php echo "Patient Name:&emsp;<text style='font-weight:bold;'>" . $patient_full_name; ?></text></p>
						</li>
                        <li class="not-completed">
                            <p><?php echo "Age:&emsp;<text style='font-weight:bold;'>" . $age; ?></text></p>
						</li>
                        <li class="completed">
                            <p><?php echo "Blood Type:&emsp;<text style='font-weight:bold;'>" . $blood_type; ?></text></p>
						</li>
                        <li class="not-completed">
                            <p><?php echo "Height:&emsp;<text style='font-weight:bold;'>" . $height . " cm"; ?></text></p>
                        </li>
                        <li class="completed">
                            <p><?php echo "Weight:&emsp;<text style='font-weight:bold;'>" . $weight . " kg"; ?></text></p>
                        </li>
                        <li class="not-completed">
                            <p><?php echo "Blood Pressure:&emsp;<text style='font-weight:bold;'>" . $blood_pressure_systolic . "/" . $blood_pressure_diastolic . " mmHg"; ?></text></p>
                        </li>
                        <li class="completed">
                            <p><?php echo "Temperature:&emsp;<text style='font-weight:bold;'>" . $temperature . " °C"; ?></text></p>
                        </li>
                        <li class="not-completed">
                            <p><?php echo "Signs & Symptoms:&emsp;<textarea rows='5' disabled style='border:none;width:500px;border-radius:10px;padding:10px;'>" . $signs_and_symptoms; ?></textarea></p>
                        </li><br/>
                        <div style="display:flex;justify-content:center;align-items:center;">
                            <button style="border:none;width:200px;height:50px;border-radius:10px;padding:20px;background-color:#008000;color:white;" onclick="window.location.href='add_to_queue.php?patient_id=<?php echo($patient_id); ?>'" title="Click to start session"><h4>Start Session</h4></button><br/>
                        </div>
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