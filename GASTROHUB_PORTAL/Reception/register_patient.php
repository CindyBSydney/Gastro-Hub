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
					<span class="text">Search Patient</span>
				</a>
			</li>
			<li class="active">
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
							<a class="active" href="">Register Patient</a>
						</li>
					</ul>
				</div>
			</div>

            <form action="process_register_patient.php" name="signup-form" method="post" autocomplete="off">
                <div class="table-data">
                    <div class="todo">
                        <div class="head">
                            <h3>Register New Patient</h3>
                        </div>
                        
                        <ul class="todo-list">
                            <li class="completed">
                                <p>
                                    <?php echo "First Name:&emsp;"?>
                                    <input style="border:none;width:300px;height:40px;border-radius:10px;padding:10px;" type="text" name="first_name" class="form-control" required/>
                                </p>
                            </li>
                            <li class="not-completed">
                                <p>
                                    <?php echo "Last Name:&emsp;"?>
                                    <input style="border:none;width:300px;height:40px;border-radius:10px;padding:10px;" type="text" name="last_name" class="form-control" required/>
                                </p>
                            </li>
                            <li class="completed">
                                <p>
                                    <?php echo "Guardian First Name:&emsp;"?>
                                    <input style="border:none;width:300px;height:40px;border-radius:10px;padding:10px;" type="text" name="guardian_first_name" class="form-control"/>
                                </p>
                            </li>
                            <li class="not-completed">
                                <p>
                                    <?php echo "Guardian Last Name:&emsp;"?>
                                    <input style="border:none;width:300px;height:40px;border-radius:10px;padding:10px;" type="text" name="guardian_last_name" class="form-control"/>
                                </p>
                            </li>
                            <li class="completed">
                                <p>
                                    <?php echo "Date Of Birth:&emsp;"?>
                                    <input style="border:none;width:300px;height:40px;border-radius:10px;padding:10px;" type="date" name="reg_dob" class="form-control" id="reg_dob" required/>
                                </p>
                            </li>
                            <li class="not-completed">
                                <p>
                                    <?php echo "Phone Number:&emsp;"?>
                                    <input style="border:none;width:300px;height:40px;border-radius:10px;padding:10px;" placeholder="+254012345678" maxlength="13" type="text" name="reg_phone_number" class="form-control" id="reg_phone_number" required/>
                                </p>
                            </li>
                            <li class="completed">
                                <p>
                                    <?php echo "Insurance Status:&emsp;"?>
                                    <select style="border:none;width:300px;height:40px;border-radius:10px;padding:10px;" name="reg_insured" class="form-control" required>
                                        <option value="0">Not Insured</option>
                                        <option value="1">Insured</option>
                                    </select>
                                </p>
                            </li>
                        </ul><br/>
                        <div style="display:flex;justify-content:center;align-items:center;">
                            <button id="reg_patient" style="border:none;width:200px;height:50px;border-radius:10px;padding:20px;background-color:#008000;color:white;" type="submit" title="Click to Register a New Patient"><h4>Register Patient</h4></button>
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