<?php
    include_once '../AUTH/connection.php';
    $user_id = $_SESSION['user_id'];
    $item_id = $_GET['item_id'];
    // get item details
    $item_sql = "SELECT * FROM tbl_library_item WHERE item_id = '$item_id'";
    $item_result = getData($item_sql);
    $item_type = $item_result['item_type'];
    $item_title = $item_result['item_title'];
    $item_author = $item_result['item_author'];
    $item_publisher = $item_result['item_publisher'];
    $item_ISBN = $item_result['item_ISBN'];
    $item_description = $item_result['item_description'];
    $item_quantity = $item_result['item_quantity'];
    $item_cost = $item_result['item_cost'];
    $item_loan_type = $item_result['item_loan_type'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>GastroHub System Portal</title>
    <?php include("../templates/head_links.php"); ?>
</head>
<body>
    <div class="container" style="height:100vh;">
        <div class="row" style="display:flex; justify-content:center; align-items:center; margin-top:5%;">
            <div class="col-md-offset-1 col-md-6">
                <h1>GastroHub System Admin Portal</h1>
                <h3>Edit item details</h3><br/>
                <form action="process_edit_library_item.php" name="verify-form" method="post" autocomplete="off">
                    <input type="number" name="item_id" value="<?php echo($item_id); ?>" hidden>
                    <div class="row form-group my-3">
                        <div class="col-md-3">    
                            <h4>Item type:</h4>
                        </div>
                        <div class="col-md-3">
                            <?php
                                // make an array of all possible item types
                                $item_types = array("book", "article", "journal", "magazine", "newspaper");
                                // remove the item type of the item being edited from the array
                                $item_types = array_diff($item_types, array($item_type));
                                // add the item type of the item being edited to the beginning of the array
                                array_unshift($item_types, $item_type);
                            ?>
                            <select name="item_type" class="form-control" required>
                                <?php
                                    // loop through the array and display all item types
                                    foreach($item_types as $item_type){
                                        echo("<option value='$item_type'>$item_type</option>");
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-3">    
                            <h4>Title:</h4>
                        </div>
                        <div class="col-md-9">
                            <input type="text" maxlength="100" name="title" class="form-control" value="<?php echo($item_title); ?>" required/>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-3">    
                            <h4>Author:</h4>
                        </div>
                        <div class="col-md-9">
                            <input type="text" maxlength="100" name="author" class="form-control" value="<?php echo($item_author); ?>"/>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-3">    
                            <h4>Publisher:</h4>
                        </div>
                        <div class="col-md-9">
                            <input type="text" maxlength="100" name="publisher" class="form-control" value="<?php echo($item_publisher); ?>"/>
                        </div>
                    </div>     
                    <div class="row form-group my-3">
                        <div class="col-md-3">    
                            <h4>Image:</h4>
                        </div>
                        <div class="col-md-9">
                            <input type="file" accept=".png" name="image" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-3">    
                            <h4>ISBN:</h4>
                        </div>
                        <div class="col-md-9">
                            <input type="text" maxlength="100" name="ISBN" class="form-control" value="<?php echo($item_ISBN); ?>"/>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-3">    
                            <h4>Description:</h4>
                        </div>
                        <div class="col-md-9">
                            <textarea type="text" maxlength="300" rows="5" name="description" class="form-control"><?php echo($item_description); ?></textarea>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-3">    
                            <h4>Quantity:</h4>
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="quantity" class="form-control" value="<?php echo($item_quantity); ?>" required/>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-3">    
                            <h4>Cost (Kshs):</h4>
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="unit_cost" class="form-control" value="<?php echo($item_cost); ?>"/>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-3">    
                            <h4>Loan Type:</h4>
                        </div>
                        <div class="col-md-3">
                            <?php
                                // make an array of all possible loan types
                                $loan_types = array("short_term", "long_term");
                                // remove the loan type of the item being edited from the array
                                $loan_types = array_diff($loan_types, array($item_loan_type));
                                // add the loan type of the item being edited to the beginning of the array
                                array_unshift($loan_types, $item_loan_type);
                            ?>
                            <select name="loan_type" class="form-control" required>
                                <?php
                                    // loop through the array and display all loan types
                                    foreach($loan_types as $loan_type){
                                        echo("<option value='$loan_type'>$loan_type</option>");
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div>
                            <input type="submit" name="submit" class="col-5 btn btn-primary" value="Edit Item"/>
                        </div>
                    </div><br/>
                    <div class="row text-center">
                        <div>
                        <a class="col-5 btn btn-warning" href="view_all_library_items.php">View all Items</a>
                        </div>
                    </div>
                    <div class="row text-center my-3">
                        <div>
                            <a class="col-2 btn btn-info" href="view_all_library_items.php">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="js/jquery.validate.min.js"></script>
</body>
</html>