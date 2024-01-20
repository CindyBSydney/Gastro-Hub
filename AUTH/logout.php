<?php
    include("connection.php");

    function kill(){
        session_unset();
        session_destroy();
    }

    if(!empty($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        $sql3 = "UPDATE `tbl_user` SET `is_verified` = '0' WHERE `user_id` = '$user_id'";
        setData($sql3);
        // Set the is_available status of the user to 1 (i.e., user is now available to process a patient)
        $sql = "UPDATE `tbl_user` SET `is_available` = '0' WHERE `user_id` = '$user_id'";
        setData($sql);
        $sql = "UPDATE `tbl_user` SET `processing` = '0' WHERE `user_id` = '$user_id'";
        setData($sql);
    }

    if(!empty($_SESSION['admin_id'])){
        kill();
        echo "<script>window.location.href='../AUTH/';</script>";
    } else{
        kill();
        echo "<script>window.location.href='login.php';</script>";
    }    
?>