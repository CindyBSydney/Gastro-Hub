<?php
    include("connection.php");
    
    $clearance_level_code = $_SESSION['clearance_level_code'];

    if(empty($_SESSION['admin_id'])){
        echo("<script>
            window.location.href='../AUTH/';
            alert('You are trying to access a restricted page. Please enter your admin identifier to proceed.');
            </script>");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>GastroHub System Portal</title>
    <?php include("../templates/head_links.php"); ?>
</head>
<body>
    <div class="container" style="height:100vh;">
        <div class="row" style="display:flex; justify-content:center; align-items:center; margin-top:5%;">
            <div class="col-md-offset-1 col-md-6">
                <h1>GastroHub System Admin Portal</h1>
                <h3>Register New User</h3>
                <form action="process_register.php" name="signup-form" method="post" autocomplete="off">
                    <div class="form-group my-3">
                        <label for="reg_name">Clearance Level Code:</label>
                        <select name="clearance_level_code" class="form-control" required>
                            <option value="L1">L1 - System Admin</option>
                            <option value="L2">L2 - Oncologist</option>
                            <option value="L3">L3 - Radiologist</option>
                            <option value="L4">L4 - Nurse</option>
                            <option value="L5">L5 - Receptionist</option>
                        </select>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-6">    
                            <label for="reg_name">First Name:</label>
                            <input type="text" name="first_name" class="form-control" required/>
                        </div>
                        <div class="col-md-6">    
                            <label for="reg_name">Last Name:</label>
                            <input type="text" name="last_name" class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group my-3">
                        <label for="reg_email">Email:</label>
                        <input type="email" name="reg_email" class="form-control" id="reg_email" required/>
                    </div>
                    <div class="form-group my-3">
                        <label for="reg_password">Password:</label>
                        <input type="password" name="reg_password" class="form-control" id="reg_password" required/>
                    </div><br/>
                    
                    <div class="row text-center">
                        <div>
                            <input type="submit" class="col-6 btn btn-success btn-reg-submit" value="Register User"/>
                        </div>
                    </div><br>
                    <div class="row text-center">
                        <div>
                            <a href="../GASTROHUB_ADMIN_PORTAL/" class="col-4 btn btn-outline-primary">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="js/jquery.validate.min.js"></script>
</body>
</html>