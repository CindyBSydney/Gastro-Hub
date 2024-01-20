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
			<li>
				<a href="patient_details.php?patient_id=<?php echo($patient_id); ?>">
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
			<li class="active">
				<a href="">
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
							<a class="active" href="">Consultation</a>
						</li>
					</ul>
				</div>
			</div>

            <form action="process_patient_commentary.php" name="signup-form" method="post" autocomplete="off">
                <div class="table-data">
                    <div class="todo">
                        <div class="head">
                            <h3>Patient Commentary</h3>
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

                            // Query the tbl_patient_visit
                            $sql = "SELECT * FROM tbl_patient_visit WHERE patient_id = '$patient_id' ORDER BY patient_visit_id DESC LIMIT 1";
                            $result = getData($sql);
                            $oncologist_queue_number = $result["oncologist_queue_number"];

                            // Query the tbl_triage
                            $sql = "SELECT * FROM tbl_triage WHERE patient_id = '$patient_id' ORDER BY triage_record_id DESC LIMIT 1";
                            $result = getData($sql);
                            $triage_record_id = $result["triage_record_id"];
                            $patient_visit_id = $result["patient_visit_id"];
                            $blood_type = $result["blood_type"];
                            $height = $result["height"];
                            $weight = $result["weight"];
                            $blood_pressure_systolic = $result["blood_pressure_systolic"];
                            $blood_pressure_diastolic = $result["blood_pressure_diastolic"];
                            $temperature = $result["temperature"];
                            $signs_and_symptoms = $result["signs_and_symptoms"];

                            // Query the tbl_patient_commentary
                            $sql = "SELECT * FROM tbl_patient_commentary WHERE patient_id = '$patient_id' ORDER BY patient_commentary_id DESC LIMIT 1";
                            $result = getData($sql);
                            $patient_commentary_id = $result["patient_commentary_id"];
                        ?>
                        
                        <ul class="todo-list">
                            <input type="number" hidden value="<?php echo($patient_commentary_id); ?>" name="patient_commentary_id"/>
                            <input type="number" hidden value="<?php echo($patient_id); ?>" name="patient_id"/>
                            <input type="number" hidden value="<?php echo($patient_visit_id); ?>" name="patient_visit_id"/>
                            <input type="number" hidden value="<?php echo($triage_record_id); ?>" name="triage_record_id"/>
                            <li class="completed">
                                <p>
                                    <?php echo "Queue Number:&emsp;"?>
                                    <input style="text-align:center;border:none;width:70px;height:40px;border-radius:10px;padding:10px;" type="text" disabled value="<?php echo($oncologist_queue_number); ?>" name="oncologist_queue_number" class="form-control"/>
                                </p>
                            </li>
                            <li class="not-completed">
                                <p>
                                    <?php echo "Patient Name:&emsp;"?>
                                    <input style="text-align:center;border:none;width:200px;height:40px;border-radius:10px;padding:10px;" type="text" disabled value="<?php echo($patient_full_name); ?>" name="patient_name" class="form-control"/>
                                </p>
                            </li>
                            <li class="completed">
                                <p>
                                    <?php echo "Blood Type:&emsp;"?>
                                    <input disabled type="text" style="text-align:center;border:none;width:120px;height:40px;border-radius:10px;padding:10px;" value="<?php echo($blood_type); ?>" name="blood_type" class="form-control" required/>
                                </p>
                            </li>
                            <li class="not-completed">
                                <p>
                                    <?php echo "Height (in cm):&emsp;"?>
                                    <input disabled type="text" style="text-align:center;border:none;width:120px;height:40px;border-radius:10px;padding:10px;" value="<?php echo($height); ?>" name="height" class="form-control" required/>
                                </p>
                            </li>
                            <li class="completed">
                                <p>
                                    <?php echo "Weight (in Kg):&emsp;"?>
                                    <input disabled type="text" style="text-align:center;border:none;width:120px;height:40px;border-radius:10px;padding:10px;" value="<?php echo($weight); ?>" name="weight" class="form-control" required/>
                                </p>
                            </li>
                            <li class="not-completed">
                                <p>
                                    <?php echo "Blood Pressure (in mmHg):&emsp;"?>
                                    <input disabled style="text-align:center;border:none;width:70px;height:40px;border-radius:10px;padding:10px;" value="<?php echo($blood_pressure_systolic); ?>" maxlength="3" type="text" name="blood_pressure_systolic" class="form-control" required/> /
                                    <input disabled style="text-align:center;border:none;width:70px;height:40px;border-radius:10px;padding:10px;" value="<?php echo($blood_pressure_diastolic); ?>" maxlength="3" type="text" name="blood_pressure_diastolic" class="form-control" required/>
                                </p>
                            </li>
                            <li class="completed">
                                <p>
                                    <?php echo "Temperature (in &deg;C):&emsp;"; ?>
                                    <input disabled type="text" style="text-align:center;border:none;width:120px;height:40px;border-radius:10px;padding:10px;" value="<?php echo($temperature); ?>" name="temperature" class="form-control" required/>
                                </p>
                            </li>
                            <li class="not-completed">
                                <p>
                                    <?php echo "Signs & Symptoms:&emsp;"; ?>
                                    <textarea disabled style="border:none;width:500px;border-radius:10px;padding:10px;" type="text" rows="5" name="signs_and_symptoms" maxlength="200" class="form-control" required><?php echo($signs_and_symptoms); ?></textarea>
                                </p>
                            </li>
                            <li class="completed">
                                <p>
                                    <?php echo "General Comment:&emsp;"; ?>
                                    <textarea style="border:none;width:500px;border-radius:10px;padding:10px;" type="text" rows="5" name="oncologist_general_comment" maxlength="200" class="form-control" required></textarea>
                                </p>
                            </li>
                            <li class="not-completed">
                                <p>
                                    <?php echo "Gastric Cancer Detection Approval:&emsp;"; ?>
                                    <select style="text-align:center;border:none;width:150px;height:40px;border-radius:10px;padding:10px;" name="cancer_detection" class="form-control" required>
                                        <option style="color:orange;" value="0">Not Approved</option>
                                        <option style="color:green;" value="1">Approved</option>
                                        <option style="color:red;" value="2">Rejected</option>
                                    </select>
                                </p>
                            </li>
                        </ul><br/>
                        <div style="display:flex;justify-content:center;align-items:center;">
                            <button style="border:none;width:200px;height:50px;border-radius:10px;padding:20px;background-color:#008000;color:white;" type="submit" title="Click to submit patient commentary"><h4>Submit Commentary</h4></button><br/>
                        </div>
                    </div>
                </div>
            </form>

		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="../../templates/dash_script.js"></script>
</body>
</html>