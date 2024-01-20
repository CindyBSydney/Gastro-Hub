<!DOCTYPE html>
<html lang="en">
<head>
    <title>GastroHub System Portal</title>
    <style>
        td {
            vertical-align: middle !important;
            min-width: 100px;
        }
    </style>
    <?php include("../templates/head_links.php"); ?>
</head>
<body>
    <div class="container my-3">
        <div class="text-center">
            <h1>GastroHub System Admin Portal</h1>
            <h3>Manage Returns and Overdues</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-hover table-dark table-bordered" style="border-radius:10px;">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Record ID</th>
                        <th>Email</th>
                        <th>Item ID</th>
                        <th>Item Type</th>
                        <th>Item Title</th>
                        <th>Item Author</th>
                        <th>Item Publisher</th>
                        <th>Item ISBN</th>
                        <th>Item Quantity</th>
                        <th>Unit Cost</th>
                        <th>Item Status</th>
                        <th>Item Loan Type</th>
                        <th>Returned</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include("../AUTH/connection.php");
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
                    $sql = "SELECT * FROM tbl_borrowing_record WHERE approved = 1 AND returned = 0 AND overdue_fine_paid = 0 ORDER BY record_id DESC LIMIT $offset, $itemsPerPage";
                    $result = $conn->query($sql);
                    $counter = $offset;

                    // Generate a row for each item
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $item_sql = "SELECT * FROM tbl_library_item WHERE item_id = " . $row["item_id"];
                            $item_result = getData($item_sql);
                            $lowercaseTitle = strtolower($item_result["item_title"]);
                            $underscoreTitle = str_replace(' ', '_', $lowercaseTitle);
                            $imageTitle = str_replace('.', '', $underscoreTitle);
                            $imageSrc = $item_result["item_image"];
                            $itemDescription = $item_result["item_description"];
                            // limit the description to 120 characters
                            if (strlen($itemDescription) > 120) {
                                $itemDescription = substr($itemDescription, 0, 120) . "...";
                            }
                            $counter++;
                            echo "<tr>";
                            ?>
                            <td><img src='<?php echo($imageSrc); ?>' style="width:100px;"></td>
                            <?php
                            echo "<td>" . $row["record_id"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $item_result["item_id"] . "</td>";
                            echo "<td>" . $item_result["item_type"] . "</td>";
                            echo "<td>" . $item_result["item_title"] . "</td>";
                            echo "<td>" . $item_result["item_author"] . "</td>";
                            echo "<td>" . $item_result["item_publisher"] . "</td>";
                            echo "<td>" . $item_result["item_ISBN"] . "</td>";
                            echo "<td>" . $item_result["item_quantity"] . "</td>";
                            echo "<td>" . $item_result["item_cost"] . "</td>";
                            echo "<td>" . $item_result["item_status"] . "</td>";
                            echo "<td>" . $item_result["item_loan_type"] . "</td>";
                            if($row['due_date'] < date("Y-m-d")){
                                ?>
                                <td><a href="process_returns.php?record_id=<?php echo($row["record_id"]); ?>&overdue_fine=<?php echo($row["overdue_fine"]); ?>" class="btn btn-outline-success">Returned / Overdue Paid</a></td>
                                <?php
                            } else {
                                ?>
                                <td><a href="process_returns.php?record_id=<?php echo($row["record_id"]); ?>&overdue_fine=<?php echo(0); ?>" class="btn btn-outline-success">Returned</a></td>
                                <?php
                            }
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='15'>No pending borrowed items found.</td></tr>";
                    }
                    ?>
                    </tbody>
            </table>
        </div>
        
        <div class="pagination">
            <?php
            // Pagination links
            $sql = "SELECT COUNT(*) AS total FROM tbl_borrowing_record WHERE approved = 1 AND returned = 0 AND overdue_fine_paid = 0";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $totalItems = $row['total'];
            $totalPages = ceil($totalItems / $itemsPerPage);

            echo "<p>Showing <big style='color:#3C91E6;'>$itemsPerPage</big> borrowed items per page of <big style='color:#3C91E6;'>$totalItems</big> total borrowed items.</p>&emsp;";
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
