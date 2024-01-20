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
                <h3>Admin Access Verification</h3><br/>
                <form action="process_admin.php" name="verify-form" method="post" autocomplete="off">
                    <div class="row form-group my-3">
                        <div class="col-md-3">    
                            <h4>Admin ID:</h4>
                        </div>
                        <div class="col-md-9">
                            <input type="number" name="admin_id" class="form-control" required/>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-3">    
                            <h4>Password:</h4>
                        </div>
                        <div class="col-md-9">
                            <input type="password" name="password" class="form-control" required/>
                        </div>
                    </div><br/>     
                    <div class="row text-center">
                        <div>
                            <input type="submit" name="submit" class="col-4 btn btn-primary btn-reg-submit" value="Verify"/>
                        </div>
                    </div><br/>
                    <div class="row text-center">
                        <text>Not an admin?&emsp;<a class="col-2 btn btn-success" href="login.php">Login here</a></text>                        
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="js/jquery.validate.min.js"></script>
</body>
</html>