<?php
    include("../AUTH/connection.php");

    $record_id = $_GET['record_id'];
    $item_loan_type = $_GET['item_loan_type'];

    $current_timestamp = date("Y-m-d H:i:s", strtotime('+1 hour'));

    if ($item_loan_type == "short_term") {
        $due_date = date('Y-m-d', strtotime('+1 day')) . ' 17:00:00';
    } else {
        $due_date = date('Y-m-d', strtotime('+1 week')) . ' 17:00:00';
    }

    $due_date_formatted = $due_date;

    // update record approval status to 1 and set the due date
    $query = "UPDATE tbl_borrowing_record SET approved = '1', approved_date = '$current_timestamp', due_date = '$due_date_formatted' WHERE record_id = '$record_id'";
    $result = setData($query);

    if($result){
        echo("<script>
            window.location.href='../OUTSHINE_ADMIN_PORTAL/view_all_bookings.php';
            alert('Booking approved successfully.');
            </script>");
    }
    else{
        echo("<script>
            window.location.href='../OUTSHINE_ADMIN_PORTAL/view_all_bookings.php';
            alert('Booking approval failed. Please try again.');
            </script>");
    }
?>