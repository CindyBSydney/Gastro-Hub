<?php
    include("connection.php");

    if(!empty($_SESSION['user_id']) && !empty($_SESSION['clearance_level_code'])){
        $user_id = $_SESSION['user_id'];
        $clearance_level_code = $_SESSION['clearance_level_code'];

        $sql="SELECT * FROM tbl_user where user_id = '".$user_id."'";
        $result = getData($sql);

        $is_verified = $result['is_verified'];

        if($is_verified == 1){
            if($clearance_level_code == "L1"){
                if(empty($_SESSION['admin_id'])){
                    echo("<script>
                        window.location.href='../AUTH/';
                        alert('Please login using your admin account ID to gain access.');
                        </script>");
                } else{
                    $_SESSION['admin_id'] = $user_id;
                    echo("<script>
                        window.location.href='../GASTROHUB_ADMIN_PORTAL/';
                        </script>");
                }
            } else if($clearance_level_code == "L2"){
                echo("<script>
                    window.location.href='../GASTROHUB_PORTAL/Oncology/dashboard.php';
                    </script>");
            } else if($clearance_level_code == "L3"){
                echo("<script>
                    window.location.href='../GASTROHUB_PORTAL/Radiology/dashboard.php';
                    </script>");
            } else if($clearance_level_code == "L4"){
                echo("<script>
                    window.location.href='../GASTROHUB_PORTAL/Triage/dashboard.php';
                    </script>");
            } else if($clearance_level_code == "L5"){
                echo("<script>
                    window.location.href='../GASTROHUB_PORTAL/Reception/dashboard.php';
                    </script>");
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>GastroHub Login Portal</title>
    <?php include("../templates/head_links.php"); ?>
</head>
<body>
<div class="container" style="height:100vh;">
        <div class="row" style="display:flex; justify-content:center; align-items:center; margin-top:5%;">
            <div class="col-md-offset-1 col-md-6">
                <h1>GastroHub Login Portal</h1>
                <form action="process_login.php" name="login-form" id="login-form" method="post" autocomplete="off">
                    <div class="form-group my-3">
                        <label for="login_email">Email:</label>
                        <input type="email" class="form-control" name="login_email" required/>
                    </div>
                    <div class="form-group my-3">
                        <label for="login_password">Password:</label>
                        <input type="password" class="form-control" name="login_password" required/>
                    </div>

                    <input type="submit" class="btn btn-success btn-login-submit" value="Login"/><br><br>
                    <a class="btn btn-outline-info" href="index.php">Admin Login</a>
                </form>
            </div>
        </div>
    </div>
    
    <script src="js/jquery.validate.min.js"></script>
</body>
</html>