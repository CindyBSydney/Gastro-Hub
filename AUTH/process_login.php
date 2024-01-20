<?php
    include("connection.php");

    require_once('../vendor/autoload.php');

    use Vectorface\GoogleAuthenticator;
    
    $gauth = new GoogleAuthenticator();
    $secret_key = $gauth->createSecret();

    $link = connect();

    $login_email = $_POST['login_email'];
    $login_password = md5($_POST['login_password']);

    $user_result = mysqli_query($link, "SELECT * FROM tbl_user WHERE email='$login_email'") or die("Could not connect".mysqli_connect_error());
    $count = mysqli_num_rows($user_result);
    if($count == 1){
        $row = mysqli_fetch_array($user_result, MYSQLI_ASSOC);
        $user_id = $row['user_id'];
        $clearance_level_code = $row['clearance_level_code'];
        
        if($login_password == $row['password']){
            $_SESSION['user_id'] = $user_id;
            $_SESSION['clearance_level_code'] = $clearance_level_code;
            echo("<script>
                window.location.href='user_confirm.php';
                </script>");
        } else{
            // Login attempt verification
            $sql2="SELECT * FROM tbl_login_attempts where user_id = '".$user_id."'";
            $result = getData($sql2);

            $last_login_attempt = strtotime($result['last_login_attempt']);
            $num_attempts = $result['num_attempts'];
            $new_num_attempts = $num_attempts + 1;

            $current_time = time();
            $seconds_since_last_login = $current_time - $last_login_attempt;
            $hours_since_last_login = floor($seconds_since_last_login / 3600);

            if($num_attempts >= 3 && $hours_since_last_login < 3){
                echo("<script>
                    window.location.href='logout.php';
                    alert('You have exceeded the maximum number of login attempts. Please contact the ICT admin.');
                    </script>");
            } else{
                $sql_login_attempt = "UPDATE `tbl_login_attempts` SET `num_attempts` =  '$new_num_attempts' WHERE `user_id` = '$user_id'";
                setData($sql_login_attempt);
                $attempts_left = 3 - $new_num_attempts;
                if($attempts_left == 0){
                    echo("<script>
                        window.location.href='login.php';
                        alert('Check your user login details. You have ".$attempts_left." attempt(s) left. Please contact an ICT admin before trying again.');
                        </script>");
                } else{
                    echo("<script>
                        window.location.href='login.php';
                        alert('Check your user login details. You have ".$attempts_left." attempt(s) left.');
                        </script>");
                }
            }
        }
    } else{
        echo("<script>
            window.location.href='login.php';
            alert('Check your user login details.');
            </script>");
    }
?>