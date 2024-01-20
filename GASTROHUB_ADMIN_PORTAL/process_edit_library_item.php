<?php
    include("../AUTH/connection.php");

    $link = connect();

    $item_id = $_POST['item_id'];
    $item_type = $_POST['item_type'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $ISBN = $_POST['ISBN'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $cost = $_POST['unit_cost'];
    $loan_type = $_POST['loan_type'];

    // remove single quotes from title, author, publisher, description
    $title = str_replace("'", "", $title);
    $author = str_replace("'", "", $author);
    $publisher = str_replace("'", "", $publisher);
    $description = str_replace("'", "", $description);

    // remove double quotes from title, author, publisher, description
    $title = str_replace('"', "", $title);
    $author = str_replace('"', "", $author);
    $publisher = str_replace('"', "", $publisher);
    $description = str_replace('"', "", $description);

    // edit library item
    $query = "UPDATE tbl_library_item SET item_type = '$item_type', item_title = '$title', item_author = '$author', item_publisher = '$publisher', item_ISBN = '$ISBN', item_description = '$description', item_quantity = '$quantity', item_cost = '$cost', item_loan_type = '$loan_type' WHERE item_id = '$item_id'";
    $result = mysqli_query($link, $query);

    if($result){
        echo("<script>
            window.location.href='../OUTSHINE_ADMIN_PORTAL/view_all_library_items.php';
            alert('Library item edited successfully.');
            </script>");
    }
    else{
        echo("<script>
            window.location.href='../OUTSHINE_ADMIN_PORTAL/view_all_library_items.php';
            alert('Library item edit failed. Please try again.');
            </script>");
    }
?>