<?php
    include_once '../AUTH/connection.php';
    $user_id = $_SESSION['user_id'];
    $item_id = $_GET['user_id'];
    // delete from tbl_user
    $deletion_sql = "DELETE FROM tbl_user WHERE user_id = '$user_id'";
    $deletion_result = setData($deletion_sql);
    if($deletion_result) {
        echo "<script>window.location.href='view_all_users.php';</script>";
    } else {
        echo "<script>alert('User deletion failed! Please try again or contact your system admin.'); window.location.href='view_all_users.php';</script>";
    }
?>