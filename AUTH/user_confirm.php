<?php
    include("connection.php");

    require_once('../vendor/autoload.php');

    use Vectorface\GoogleAuthenticator;
    
    $gauth = new GoogleAuthenticator();

    $link = connect();
    $user_id = $_SESSION['user_id'];
    $user_result = mysqli_query($link, "SELECT * FROM `tbl_user` WHERE `user_id` = '$user_id'") or die("Could not connect".mysqli_connect_error());
    $row = mysqli_fetch_array($user_result, MYSQLI_ASSOC);
    $secret_key = $row['google_auth_code'];
    $email = $row['email'];

    $google_QR_Code = $gauth->getQRCodeUrl($email, $secret_key, '2-Step Verification');

    if(!empty($_SESSION['user_id']) && !empty($_SESSION['clearance_level_code'])){
        $user_id = $_SESSION['user_id'];
        $clearance_level_code = $_SESSION['clearance_level_code'];

        $sql="SELECT * FROM tbl_user where user_id = '".$user_id."'";
        $result = getData($sql);

        $is_verified = $result['is_verified'];
        $suspended = $result['suspended'];
        $deactivated = $result['deactivated'];
        $current_date = date("y-m-d h:i:s");
        $disabled_end_date = $result['disabled_end_date'];

        if($is_verified == 1 && $suspended == 0 && $deactivated == 0 && $disabled_end_date <= $current_date){
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
        } elseif($suspended == 1){
            echo("<script>
                window.location.href='../AUTH/login.php';
                alert('Your account has been suspended. Please contact the administrator for more information.');
                </script>");
        } elseif($deactivated == 1){
            echo("<script>
            window.location.href='../AUTH/login.php';
            alert('This account has been deactivated. Please contact the administrator for more information.');
            </script>");
        } elseif($disabled_end_date > $current_date){
            echo("<script>
            window.location.href='../AUTH/login.php';
            alert('This account has been disabled for 3 months due to violations. Please contact the administrator for more information.');
            </script>");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>GastroHub 2-Factor Verification</title>
    <link rel="stylesheet" type="text/css" href="css/app_style.css">
    <?php include("../templates/head_links.php"); ?>
</head>
<body>
    <div class="container text-center">
        <div class="row my-3">
            <div>
                <h1>GastroHub 2-Factor Verification</h1>
                <div id="device">
                    <p>Scan with Google Authenticator application on your smartphone.</p>
                    <div id="img">
                        <img src="<?php echo $google_QR_Code; ?>" alt="QR CODE IMAGE">  
                    </div>

                    <form action="process_qr.php" id="LI-form" method="post" autocomplete="off">
                        <div class="form-group my-3" style="display:grid;">
                            <label for="scan_code">Place your code here:</label>
                            <input type="text" name="scan_code" class="form-control" style="width: 300px; place-self:center;" id="scan_code" required/>
                        </div>

                        <input type="submit" class="btn btn-success btn-submit" value="Verify Code"/>
                    </form>
                </div>

                <div class="my-3">
                    <h5>Download Google Authenticator <br/>application using the link(s) below</h5>
                    <a href="https://itunes.apple.com/us/app/google-authenticator/id388497605?mt=8" target="_blank"><img class="app" src="../images/app_store.png" alt="App Store" width="100px" aria-label="App Store"/></a>&emsp;&emsp;
                    <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank"><img class="app" src="../images/google_play.png" alt="Google Play Store" width="100px" aria-label="Google Play Store"/></a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="js/jquery.validate.min.js"></script>
</body>
</html>