<?php
    include("../AUTH/connection.php");

    $item_type = $_POST['item_type'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $ISBN = $_POST['ISBN'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $cost = $_POST['unit_cost'];
    $loan_type = $_POST['loan_type'];
    $user_id = $_SESSION['user_id'];

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

    $bookTitle = strtolower(str_replace(' ', '_', $_POST['title'])); // Get the book title and convert it to lowercase with underscores
    $bookTitle = str_replace("'", "", $bookTitle); // Remove single quotes from the title
    $bookTitle = str_replace('"', "", $bookTitle); // Remove double quotes from the title

    $image_name = "../images/default.png";

    if(!empty($_FILES['image'])){
        $file=$_FILES['image'];
        // print_r($file);
        $file_path="../images/";
        $original_file_name=$_FILES['image']['name'];
        $file_tmp_location=$_FILES['image']['tmp_name'];
        if(move_uploaded_file($file_tmp_location, $file_path.$original_file_name)){
            $combined = $file_path.$original_file_name;
            $image_name = $combined;
        }
    }

    $query = "INSERT INTO tbl_library_item(item_type, item_title, item_author, item_publisher, item_ISBN, item_description, item_quantity, item_cost, item_loan_type, item_image) VALUES('$item_type', '".$title."', '".$author."', '".$publisher."', '$ISBN', '".$description."', '$quantity', '$cost', '$loan_type', '$image_name')";
    $result = setData($query);

    if($result){
        echo("<script>
            window.location.href='../OUTSHINE_ADMIN_PORTAL/add_library_item.php';
            alert('Library item added successfully.');
            </script>");
    }
    else{
        echo("<script>
            window.location.href='../OUTSHINE_ADMIN_PORTAL/add_library_item.php';
            alert('Library item addition failed. Please try again.');
            </script>");
    }
?>