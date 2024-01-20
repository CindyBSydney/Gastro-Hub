<!DOCTYPE html>
<html lang="en">
<head>
    <title>GastroHub System Portal</title>
    <?php include("../templates/head_links.php"); ?>
</head>
<body>
    <div class="container my-3">
        <div class="text-center">
            <h1>GastroHub System Admin Portal</h1>
            <h3>Library Users</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-hover table-dark table-bordered" style="border-radius:10px;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>User ID</th>
                        <th>Email</th>
                        <th>Full Name</th>
                        <th>Auth Code</th>
                        <th>Clearance Level</th>
                        <th>Suspended (Active/Suspended)</th>
                        <th>Active Status (Active/Deactivated)</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Establish a database connection
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "gastrohub_db";
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Pagination variables
                    $itemsPerPage = 3;
                    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($currentPage - 1) * $itemsPerPage;

                    // Query to retrieve a specific range of items
                    $sql = "SELECT * FROM tbl_user WHERE (clearance_level_code = 'L4' OR clearance_level_code = 'L5') ORDER BY last_name LIMIT $offset, $itemsPerPage";
                    $result = $conn->query($sql);
                    $counter = $offset;

                    // Generate a row for each item
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $counter++;
                            echo "<tr>";
                            echo "<td>" . $counter . "</td>";
                            echo "<td>" . $row["user_id"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            $fullName = $row["last_name"] . " " . $row["first_name"];
                            echo "<td>" . $fullName . "</td>";
                            echo "<td>" . $row["google_auth_code"] . "</td>";
                            echo "<td>" . $row["clearance_level"] . "</td>";
                            if($row["suspended"] == 0){
                                echo "<td class='text-success'>Active</td>";
                            } else {
                                echo "<td class='text-danger'>Suspended</td>";
                            }
                            if($row["deactivated"] == 0){
                                echo "<td class='text-success'>Active</td>";
                            } else {
                                echo "<td class='text-danger'>Deactivated</td>";
                            }
                            ?>
                            <td><a href="edit_user.php?user_id=<?php echo($row["user_id"]); ?>" class="btn btn-outline-success">Edit</a></td>
                            <td><a href="delete_user.php?user_id=<?php echo($row["user_id"]); ?>" class="btn btn-outline-danger">Delete</a></td>
                            <?php
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='15'>No users found.</td></tr>";
                    }
                    ?>
                    </tbody>
            </table>
        </div>
        
        <div class="pagination">
            <?php
            // Pagination links
            $sql = "SELECT COUNT(*) AS total FROM tbl_user WHERE (clearance_level_code = 'L4' OR clearance_level_code = 'L5')";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $totalItems = $row['total'];
            $totalPages = ceil($totalItems / $itemsPerPage);

            echo "<p>Showing <big style='color:#3C91E6;'>$itemsPerPage</big> users per page of <big style='color:#3C91E6;'>$totalItems</big> total users.</p>&emsp;";
            echo "<ul class='pagination justify-content-center'>";
            for ($i = 1; $i <= $totalPages; $i++) {
                $activeClass = ($i == $currentPage) ? 'active' : '';
                echo "<li class='page-item $activeClass'><a class='page-link' href='?page=$i'>$i</a></li>";
            }
            echo "</ul>";
            ?>
        </div>
    </div>
</body>
</html>
