<?php
    include("../AUTH/connection.php");

    $record_id = $_GET['record_id'];

    // update record approval status to 2
    $query = "UPDATE tbl_borrowing_record SET approved = '2' WHERE record_id = '$record_id'";
    $result = setData($query);

    if($result){
        echo("<script>
            window.location.href='../OUTSHINE_ADMIN_PORTAL/view_all_bookings.php';
            alert('Booking rejected successfully.');
            </script>");
    }
    else{
        echo("<script>
            window.location.href='../OUTSHINE_ADMIN_PORTAL/view_all_bookings.php';
            alert('Booking rejection failed. Please try again.');
            </script>");
    }
?>