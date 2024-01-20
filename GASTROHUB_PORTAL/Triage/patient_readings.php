<?php
    include_once '../../AUTH/connection.php';
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT first_name FROM tbl_user WHERE user_id = '$user_id'";
    $result = getData($sql);
    $first_name = $result['first_name'];

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
			<li class="active">
				<a href="">
                    <i class='bx bxs-thermometer' ></i>
					<span class="text">Patient Readings</span>
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
					<h1>Triage</h1>
					<ul class="breadcrumb">
						<li>
							<a href="dashboard.php">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="">Patient Readings</a>
						</li>
					</ul>
				</div>
			</div>

            <form action="process_patient_readings.php" name="signup-form" method="post" autocomplete="off">
                <div class="table-data">
                    <div class="todo">
                        <div class="head">
                            <h3>Take Patient Readings</h3>
                        </div>

                        <?php
                            // Get the patient's details
                            $sql = "SELECT * FROM tbl_patient WHERE patient_id = '$patient_id'";
                            $result = getData($sql);
                            $patient_first_name = $result['first_name'];
                            $patient_last_name = $result['last_name'];
                            $patient_full_name = $patient_first_name." ".$patient_last_name;
                            // Get the patient's most recent visit details
                            $sql = "SELECT * FROM tbl_patient_visit WHERE patient_id = '$patient_id' ORDER BY patient_visit_id DESC LIMIT 1";
                            $result = getData($sql);
                            $patient_visit_id = $result['patient_visit_id'];
                            $triage_queue_number = $result['triage_queue_number'];
                            // Get the patient's most recent data from the tbl_triage
                            $sql = "SELECT * FROM tbl_triage WHERE patient_visit_id = '$patient_visit_id' ORDER BY triage_record_id DESC LIMIT 1";
                            $result = getData($sql);
                            $triage_record_id = $result['triage_record_id'];
                            $blood_type = $result['blood_type'];
                            $weight = $result['weight'];
                            $height = $result['height'];                        
                        ?>
                        
                        <ul class="todo-list">
                            <input type="number" hidden value="<?php echo($patient_id); ?>" name="patient_id"/>
                            <input type="number" hidden value="<?php echo($patient_visit_id); ?>" name="patient_visit_id"/>
                            <input type="number" hidden value="<?php echo($triage_record_id); ?>" name="triage_record_id"/>
                            <li class="completed">
                                <p>
                                    <?php echo "Queue Number:&emsp;"?>
                                    <input style="border:none;width:300px;height:40px;border-radius:10px;padding:10px;" type="number" disabled value="<?php echo($triage_queue_number); ?>" name="triage_queue_number" class="form-control"/>
                                </p>
                            </li>
                            <li class="not-completed">
                                <p>
                                    <?php echo "Patient Name:&emsp;"?>
                                    <input style="border:none;width:300px;height:40px;border-radius:10px;padding:10px;" type="text" disabled value="<?php echo($patient_full_name); ?>" name="patient_name" class="form-control"/>
                                </p>
                            </li>
                            <li class="completed">
                                <p>
                                    <?php echo "Blood Type:&emsp;"?>
                                    <select style="text-align:center;border:none;width:70px;height:40px;border-radius:10px;padding:10px;" name="blood_type" class="form-control" required>
                                        <option value="A+" <?php echo ($blood_type == 'A+') ? 'selected' : ''; ?>>A+</option>
                                        <option value="A-" <?php echo ($blood_type == 'A-') ? 'selected' : ''; ?>>A-</option>
                                        <option value="B+" <?php echo ($blood_type == 'B+') ? 'selected' : ''; ?>>B+</option>
                                        <option value="B-" <?php echo ($blood_type == 'B-') ? 'selected' : ''; ?>>B-</option>
                                        <option value="AB+" <?php echo ($blood_type == 'AB+') ? 'selected' : ''; ?>>AB+</option>
                                        <option value="AB-" <?php echo ($blood_type == 'AB-') ? 'selected' : ''; ?>>AB-</option>
                                        <option value="O+" <?php echo ($blood_type == 'O+') ? 'selected' : ''; ?>>O+</option>
                                        <option value="O-" <?php echo ($blood_type == 'O-') ? 'selected' : ''; ?>>O-</option>
                                    </select>
                                </p>
                            </li>
                            <li class="not-completed">
                                <p>
                                    <?php echo "Height (in cm):&emsp;"?>
                                    <input type="number" style="text-align:center;border:none;width:120px;height:40px;border-radius:10px;padding:10px;" value="<?php echo($height); ?>" name="height" class="form-control" required/>
                                </p>
                            </li>
                            <li class="completed">
                                <p>
                                    <?php echo "Weight (in Kg):&emsp;"?>
                                    <input type="number" style="text-align:center;border:none;width:120px;height:40px;border-radius:10px;padding:10px;" value="<?php echo($weight); ?>" name="weight" class="form-control" required/>
                                </p>
                            </li>
                            <li class="not-completed">
                                <p>
                                    <?php echo "Blood Pressure:&emsp;"?>
                                    <input maxlength="3" style="text-align:center;border:none;width:70px;height:40px;border-radius:10px;padding:10px;" maxlength="3" type="number" name="blood_pressure_systolic" class="form-control" required/> /
                                    <input maxlength="3" style="text-align:center;border:none;width:70px;height:40px;border-radius:10px;padding:10px;" maxlength="3" type="number" name="blood_pressure_diastolic" class="form-control" required/>
                                </p>
                            </li>
                            <li class="completed">
                                <p>
                                    <?php echo "Temperature (in &deg;C):&emsp;"; ?>
                                    <select style="text-align:center;border:none;width:70px;height:40px;border-radius:10px;padding:10px;" type="number" name="temperature" class="form-control" required>
                                        <?php
                                            for ($i = 35; $i <= 42; $i++) {
                                                echo "<option value='$i'>$i</option>";
                                            }
                                        ?>
                                    </select>
                                </p>
                            </li>
                            <li class="not-completed">
                                <p>
                                    <?php echo "Signs & Symptoms:&emsp;"; ?>
                                    <textarea style="border:none;width:500px;border-radius:10px;padding:10px;" type="text" rows="5" name="signs_and_symptoms" maxlength="200" class="form-control" required></textarea>
                                </p>
                            </li>
                        </ul><br/>
                        <div style="display:flex;justify-content:center;align-items:center;">
                            <button style="border:none;width:200px;height:50px;border-radius:10px;padding:20px;background-color:#008000;color:white;" type="submit" title="Click to submit patient readings"><h4>Submit Readings</h4></button><br/>
                            <!-- <button style="border:none;width:200px;height:50px;border-radius:10px;padding:20px;background-color:red;color:white;" onclick="window.location.href='cancel_patient_readings.php?triage_record_id=<?php //echo($triage_record_id); ?>'" title="Click to cancel"><h4>Cancel</h4></button> -->
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