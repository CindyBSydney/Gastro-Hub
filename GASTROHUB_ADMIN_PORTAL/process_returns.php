<?php
    include("../AUTH/connection.php");

    $record_id = $_GET['record_id'];
    $overdue_fine = $_GET['overdue_fine'];

    $current_timestamp = date("Y-m-d H:i:s");
    $returned = 1;
    $overdue = 0;
    $overdue_fine_paid = $overdue_fine;
    $overdue_fine_paid_date = $current_timestamp;
    // set disabled end date to 3 months from now
    $disabled_end_date = date('Y-m-d', strtotime('+3 months')) . ' 17:00:00';

    if($overdue_fine == 0){
        $query = "UPDATE tbl_borrowing_record SET returned = '$returned', returned_date = '$current_timestamp', overdue = '$overdue' WHERE record_id = '$record_id'";
    } else {
        $query = "UPDATE tbl_borrowing_record SET returned = '$returned', returned_date = '$current_timestamp', overdue = '$overdue', overdue_fine_paid = '$overdue_fine_paid', overdue_fine_paid_date = '$overdue_fine_paid_date', disabled_end_date = '$disabled_end_date' WHERE record_id = '$record_id'";
    }
    $result = setData($query);

    if($result){
        echo("<script>
            window.location.href='../OUTSHINE_ADMIN_PORTAL/manage_returns.php';
            alert('Return processed successfully.');
            </script>");
    }
    else{
        echo("<script>
            window.location.href='../OUTSHINE_ADMIN_PORTAL/manage_returns.php';
            alert('Return processing failed. Please try again.');
            </script>");
    }
?>