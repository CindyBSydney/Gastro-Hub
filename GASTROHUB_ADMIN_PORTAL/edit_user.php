<?php
    include_once '../AUTH/connection.php';
    $user_id = $_GET['user_id'];
    // get item details
    $user_sql = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
    $user_result = getData($user_sql);
    $email = $user_result['email'];
    $password = md5($user_result['password']);
    $first_name = $user_result['first_name'];
    $last_name = $user_result['last_name'];
    $suspended = $user_result['suspended']; // 0 = not suspended, 1 = suspended
    $deactivated = $user_result['deactivated']; // 0 = not deactivated, 1 = deactivated
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
                <h3>Edit user details</h3><br/>
                <form action="process_edit_user.php" name="verify-form" method="post" autocomplete="off">
                    <input type="number" name="user_id" value="<?php echo($user_id); ?>" hidden>
                    <div class="row form-group my-3">
                        <div class="col-md-5">    
                            <h4>User Email:</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="email" name="email" class="form-control" value="<?php echo($email); ?>" required/>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-5">    
                            <h4>User Password:</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="password" name="password" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-5">    
                            <h4>First Name:</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" name="first_name" class="form-control" value="<?php echo($first_name); ?>" required/>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-5">    
                            <h4>Last Name:</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" name="last_name" class="form-control" value="<?php echo($last_name); ?>" required/>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-5">    
                            <h4>Suspension Status:</h4>
                        </div>
                        <div class="col-md-3">
                            <select name="suspended" class="form-control" required>
                                <?php
                                    if($suspended == 0){
                                        echo("<option class='text-success' value='0' selected>Not suspended</option>");
                                        echo("<option class='text-danger' value='1'>Suspended</option>");
                                    }else{
                                        echo("<option class='text-success' value='0'>Not suspended</option>");
                                        echo("<option class='text-danger' value='1' selected>Suspended</option>");
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-5">    
                            <h4>Activity Status:</h4>
                        </div>
                        <div class="col-md-3">
                            <select name="deactivated" class="form-control" required>
                                <?php
                                    if($deactivated == 0){
                                        echo("<option class='text-success' value='0' selected>Active</option>");
                                        echo("<option class='text-danger' value='1'>Deactivated</option>");
                                    }else{
                                        echo("<option class='text-success' value='0'>Active</option>");
                                        echo("<option class='text-danger' value='1' selected>Deactivated</option>");
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <p><text style="color:red;font-weight:bold;">Please note:</text> For every change, the user password will reset to the default unless the password is manually changed.</p>
                    <div class="row text-center">
                        <div>
                            <input type="submit" name="submit" class="col-5 btn btn-primary" value="Edit User"/>
                        </div>
                    </div><br/>
                    <div class="row text-center">
                        <div>
                        <a class="col-5 btn btn-warning" href="view_all_users.php">View all Users</a>
                        </div>
                    </div>
                    <div class="row text-center my-3">
                        <div>
                            <a class="col-2 btn btn-info" href="view_all_users.php">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="js/jquery.validate.min.js"></script>
</body>
</html>