<?php
    include_once '../../AUTH/connection.php';
    $user_id = $_SESSION['user_id'];
    $triage_record_id = $_GET['triage_record_id'];
    
    // delete from tbl_triage
    $triage_sql = "DELETE FROM tbl_triage WHERE triage_record_id = '$triage_record_id'";
    $triage_result = setData($triage_sql);
    $sql = "UPDATE `tbl_user` SET `processing` = '0' WHERE `user_id` = '$user_id'";
    $processing = setData($sql);
    if($triage_result && $processing) {
        echo "<script>alert('Triage visit cancelled.'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Triage visit cancellation failed! Please contact system admin.'); window.location.href='dashboard.php';</script>";
    }
?>