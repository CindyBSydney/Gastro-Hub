<div id="container">        
    <div class="row my-3 text-center" style="display:flex;justify-content:center;">
        <h1>Hello <?php echo ($row['first_name']); ?></h1>
        <h3>Welcome to your page.</h3>
        <p>Here you can see your <?php echo($row['clearance_level']);?> profile details.</p>
        <div class="col-2">    
            <h4>First Name:</h4>
        </div>
        <div class="col-4">
            <input type="text" class="form-control" value="<?php echo $row['first_name']; ?>" disabled/>
        </div>
    </div>
    <div class="row my-3 text-center" style="display:flex;justify-content:center;">
        <div class="col-2">    
            <h4>Last Name:</h4>
        </div>
        <div class="col-4">
            <input type="text" class="form-control" value="<?php echo $row['last_name']; ?>" disabled/>
        </div>
    </div>
    <div class="row my-3 text-center" style="display:flex;justify-content:center;">
        <div class="col-2">    
            <h4>Admin ID:</h4>
        </div>
        <div class="col-4">
            <input type="text" class="form-control" value="<?php echo $row['user_id']; ?>" disabled/>
        </div>
    </div>
    <div class="row my-3 text-center" style="display:flex;justify-content:center;">
        <div class="col-2">    
            <h4>Email:</h4>
        </div>
        <div class="col-4">
            <input type="text" class="form-control" value="<?php echo $row['email']; ?>" disabled/>
        </div>
    </div>
    <div class="row my-3 text-center" style="display:flex;justify-content:center;">
        <div class="col-2">    
            <h4>Secret key:</h4>
        </div>
        <div class="col-4">
            <input type="text" class="form-control" value="<?php echo $row['google_auth_code']; ?>" disabled/>
        </div>
    </div>
    <br/>
    <div class="row my-3 text-center" style="display:flex;justify-content:center;">
        <h3>My Admin</h3>
        <p>Click here to generate a report => <a target="_blank" class="btn btn-outline-info" href="../GASTROHUB_ADMIN_PORTAL/generate_report.php" style="width:fit-content;">Generate Report</a></p>
        <p>Click here to register users => <a target="_blank" class="btn btn-outline-success" href="../AUTH/register.php" style="width:fit-content;">Register New Users</a></p>
        <p>Click here to view all bookings => <a target="_blank" class="btn btn-outline-info" href="../GASTROHUB_ADMIN_PORTAL/view_all_bookings.php" style="width:fit-content;">View all bookings</a></p>
        <p>Click here to add inventory => <a target="_blank" class="btn btn-outline-warning" href="../GASTROHUB_ADMIN_PORTAL/add_library_item.php" style="width:fit-content;">Add item to inventory</a></p>
        <p>Click here to view all inventory => <a target="_blank" class="btn btn-outline-info" href="../GASTROHUB_ADMIN_PORTAL/view_all_library_items.php" style="width:fit-content;">View all inventory</a></p>
        <p>Click here to view all users => <a target="_blank" class="btn btn-outline-success" href="../GASTROHUB_ADMIN_PORTAL/view_all_users.php" style="width:fit-content;">View all users</a></p>
        <p>Click here to manage returns => <a target="_blank" class="btn btn-outline-warning" href="../GASTROHUB_ADMIN_PORTAL/manage_returns.php" style="width:fit-content;">Manage returns</a></p>
        <p>Click here to logout of your account => <a class="col-1 btn btn-xs btn-outline-danger" href="../AUTH/logout.php" style="width:fit-content;">Logout</a></p>
    </div>
</div>