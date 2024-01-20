<?php
    if(empty($_SESSION['user_id'])){
        echo "<script>
            window.location.href='../AUTH/login.php';
            alert('Please login to view this page.');
            </script>";
    }

    $link = connect();
    $user_id = $_SESSION['user_id'];
    $user_result = mysqli_query($link, "SELECT * FROM `tbl_user` WHERE `user_id` = '$user_id'") or die("Could not connect".mysqli_connect_error());
    $row = mysqli_fetch_array($user_result, MYSQLI_ASSOC);
?>