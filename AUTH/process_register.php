<?php
    include("connection.php");

    require_once('../vendor/autoload.php');

    use Vectorface\GoogleAuthenticator;
    
    $gauth = new GoogleAuthenticator();
    $secret_key = $gauth->createSecret();

    $link = connect();

    $clearance_level_code = $_POST['clearance_level_code'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $reg_email = $_POST['reg_email'];
    $reg_password = md5($_POST['reg_password']);

    $chk_user = mysqli_query($link, "SELECT * FROM tbl_user WHERE email = '$reg_email'") or die("Could not connect".mysqli_connect_error());
    $count = mysqli_num_rows($chk_user);
    if($count == 0){
        $sql_clearance_level = "SELECT * FROM tbl_user_clearance_level WHERE clearance_level_code = '$clearance_level_code'";
        $result_clearance_level = getData($sql_clearance_level);
        $clearance_level_id = $result_clearance_level['clearance_level_id'];
        $clearance_level = $result_clearance_level['clearance_level'];

        $sql_insert = "INSERT INTO tbl_user(first_name,last_name,email,password,google_auth_code,clearance_level_id,clearance_level_code,clearance_level) VALUES('$first_name','$last_name','$reg_email','$reg_password','$secret_key','$clearance_level_id','$clearance_level_code','$clearance_level')";
        $result = setData($sql_insert);
        if($result){
            $sql="SELECT * FROM tbl_user where email = '".$reg_email."'";
            $result = getData($sql);
            if(!empty($result)){
                $new_user_id = $result['user_id'];
                $sql_insert2 = "INSERT INTO tbl_login_attempts(user_id,email) VALUES('$new_user_id','$reg_email')";
                $result2 = setData($sql_insert2);
                $_SESSION['user_id'] = $new_user_id;
                $_SESSION['clearance_level_code'] = $clearance_level_code;
                echo("<script>
                    window.location.href='register.php';
                    alert('Registration successful. ');
                    </script>");
            } else{
                echo("<script>
                    window.location.href='register.php';
                    alert('Registration failed. Please try again.');
                    </script>");
            }
        } else{
            echo("<script>
                window.location.href='register.php';
                alert('There is an error in the registration process. Please try again.');
                </script>");
        }
    } else{
        echo("<script>
            window.location.href='register.php';
            alert('Email already exists. Please try again.');
            </script>");
    }
?>