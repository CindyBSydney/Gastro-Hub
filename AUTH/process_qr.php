<?php
    include("connection.php");

    require_once('../vendor/autoload.php');

    use Vectorface\GoogleAuthenticator;
    
    $gauth = new GoogleAuthenticator();
    $secret_key = $gauth->createSecret();

    $link = connect();

    $scan_code = $_POST['scan_code'];
    $user_id = $_SESSION['user_id'];

    function redirect($user_id,$clearance_level_code, $scan_code, $clearance_level){
        $_SESSION['googleVerifyCode'] = $scan_code;
        $sql = "UPDATE `tbl_user` SET `is_verified` = '1' WHERE `user_id` = '$user_id'";
        setData($sql);
        // Set the is_available status of the user to 1 (i.e., user is now available to process a patient)
        $sql = "UPDATE `tbl_user` SET `is_available` = '1' WHERE `user_id` = '$user_id'";
        setData($sql);

        if($clearance_level_code == "L1"){
            if(empty($_SESSION['admin_id'])){
                echo("<script>
                    window.location.href='../AUTH/';
                    alert('Please login using your admin account ID to gain access.');
                    </script>");
            } else{
                $_SESSION['admin_id'] = $user_id;
                echo("<script>
                    alert('".$clearance_level." verification successful. You are now logged in.');
                    window.location.href='../GASTROHUB_ADMIN_PORTAL/';
                    </script>");
            }
        } else if($clearance_level_code == "L2"){
            echo("<script>
                alert('".$clearance_level." verification successful. You are now logged in.');
                window.location.href='../GASTROHUB_PORTAL/Oncology/dashboard.php';
                </script>");
        } else if($clearance_level_code == "L3"){
            echo("<script>
                alert('".$clearance_level." verification successful. You are now logged in.');
                window.location.href='../GASTROHUB_PORTAL/Radiology/dashboard.php';
                </script>");
        } else if($clearance_level_code == "L4"){
            echo("<script>
                alert('".$clearance_level." verification successful. You are now logged in.');
                window.location.href='../GASTROHUB_PORTAL/Triage/dashboard.php';
                </script>");
        } else if($clearance_level_code == "L5"){
            echo("<script>
                alert('".$clearance_level." verification successful. You are now logged in.');
                window.location.href='../GASTROHUB_PORTAL/Reception/dashboard.php';
                </script>");
        }
    }

    $user_result = mysqli_query($link, "SELECT * FROM `tbl_user` WHERE `user_id` = '$user_id'") or die("Could not connect".mysqli_connect_error());
    $row = mysqli_fetch_array($user_result, MYSQLI_ASSOC);
    $secret_key = $row['google_auth_code'];
    $clearance_level_code = $row['clearance_level_code'];
    $_SESSION['clearance_level_code'] = $clearance_level_code;
    $clearance_level = $row['clearance_level'];

    $checkResult = $gauth->verifyCode($secret_key, $scan_code, 2);
    if($checkResult){
        $sql = "UPDATE `tbl_user` SET `is_verified` = '1' WHERE `user_id` = '$user_id'";
        setData($sql);

        $sql2="SELECT * FROM tbl_login_attempts where user_id = '".$user_id."'";
        $result = getData($sql2);
        $num_attempts = $result['num_attempts'];

        $sql3 = "UPDATE `tbl_login_attempts` SET `num_attempts` = '$num_attempts' WHERE `user_id` = '$user_id'";
        setData($sql3);

        redirect($user_id,$clearance_level_code, $scan_code, $clearance_level);
    } else{
        echo("<script>
            window.location.href='user_confirm.php';
            alert('Invalid verification code. Please try again.');
            </script>");
    }
?>