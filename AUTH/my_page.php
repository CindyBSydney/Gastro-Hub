<?php
    include("connection.php");

    if(empty($_SESSION['user_id'])){
        echo "<script>
            window.location.href='login.php';
            alert('Please login to view this page.');
            </script>";
    }

    $link = connect();
    $user_id = $_SESSION['user_id'];
    $user_result = mysqli_query($link, "SELECT * FROM `tbl_user` WHERE `user_id` = '$user_id'") or die("Could not connect".mysqli_connect_error());
    $row = mysqli_fetch_array($user_result, MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>GastroHub Management System Portal</title>
    <?php include("../templates/head_links.php"); ?>
</head>
<body>
    <div id="container">
        <h1>Hi <?php echo ($row['full_name']); ?></h1>
        <h3>Welcome to your page.</h3>
        <p>Here you can see your profile details.</p>

        <table class="user-table">
            <tr><td colspan="3" style="text-align:center;" class="title">User Profile Details:</td></tr>
            <tr>
                <th>Full Name</th>
                <td><?php echo $row['full_name']; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $row['email']; ?></td>
            </tr>
            <tr>
                <th>Secret Key</th>
                <td><?php echo $row['google_auth_code']; ?></td>
            </tr>
            <tr><td colspan="3" style="text-align:center;"><a href="logout.php" class="btn btn-xs btn-danger">Logout</a></td></tr>
        </table>
        <h4></h4>
    </div>
</body>
</html>