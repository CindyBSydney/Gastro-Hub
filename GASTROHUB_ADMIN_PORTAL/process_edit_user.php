<?php
    include("../AUTH/connection.php");

    $link = connect();

    $user_id = $_POST['user_id'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    if(!empty($_POST['password'])){
        $password = md5($_POST['password']);
    } else {
        $password = md5($first_name . $last_name);
    }
    $suspended = $_POST['suspended'];
    $deactivated = $_POST['deactivated'];

    $query = "UPDATE tbl_user SET email = '$email', password = '$password', first_name = '$first_name', last_name = '$last_name', suspended = '$suspended', deactivated = '$deactivated' WHERE user_id = '$user_id'";
    $result = setData($query);

    if($result){
        echo("<script>
            window.location.href='../OUTSHINE_ADMIN_PORTAL/view_all_users.php';
            alert('User details updated successfully.');
            </script>");
    }
    else{
        echo("<script>
            window.location.href='../OUTSHINE_ADMIN_PORTAL/view_all_users.php';
            alert('User detail update failed. Please try again.');
            </script>");
    }
?>