<?php
    include_once '../AUTH/connection.php';
    $user_id = $_SESSION['user_id'];
    $item_id = $_GET['item_id'];
    // delete from tbl_library_item
    $deletion_sql = "DELETE FROM tbl_library_item WHERE item_id = '$item_id'";
    $deletion_result = setData($deletion_sql);
    if($deletion_result) {
        echo "<script>window.location.href='view_all_library_items.php';</script>";
    } else {
        echo "<script>alert('Item deletion failed! Please try again or contact your system admin.'); window.location.href='view_all_library_items.php';</script>";
    }
?>