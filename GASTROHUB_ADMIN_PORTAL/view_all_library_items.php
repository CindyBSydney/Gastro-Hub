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
            <h3>Library inventory</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-hover table-dark table-bordered" style="border-radius:10px;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Item ID</th>
                        <th>Item Type</th>
                        <th>Item Title</th>
                        <th>Item Author</th>
                        <th>Item Publisher</th>
                        <th>Item ISBN</th>
                        <th>Item Description</th>
                        <th>Item Image</th>
                        <th>Item Quantity</th>
                        <th>Unit Cost</th>
                        <th>Item Status</th>
                        <th>Item Loan Type</th>
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
                    $sql = "SELECT * FROM tbl_library_item ORDER BY item_id DESC LIMIT $offset, $itemsPerPage";
                    $result = $conn->query($sql);
                    $counter = $offset;

                    // Generate a row for each item
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $lowercaseTitle = strtolower($row["item_title"]);
                            $underscoreTitle = str_replace(' ', '_', $lowercaseTitle);
                            $imageTitle = str_replace('.', '', $underscoreTitle);
                            $imageSrc = $row["item_image"];
                            $itemDescription = $row["item_description"];
                            // limit the description to 120 characters
                            if (strlen($itemDescription) > 120) {
                                $itemDescription = substr($itemDescription, 0, 120) . "...";
                            }
                            $counter++;
                            echo "<tr>";
                            echo "<td>" . $counter . "</td>";
                            ?>
                            <td><img src='<?php echo($imageSrc); ?>' style="width:100px;"></td>
                            <?php
                            echo "<td>" . $row["item_id"] . "</td>";
                            echo "<td>" . $row["item_type"] . "</td>";
                            echo "<td>" . $row["item_title"] . "</td>";
                            echo "<td>" . $row["item_author"] . "</td>";
                            echo "<td>" . $row["item_publisher"] . "</td>";
                            echo "<td>" . $row["item_ISBN"] . "</td>";
                            echo "<td>" . $itemDescription . "</td>";
                            echo "<td>" . $row["item_quantity"] . "</td>";
                            echo "<td>" . $row["item_cost"] . "</td>";
                            echo "<td>" . $row["item_status"] . "</td>";
                            echo "<td>" . $row["item_loan_type"] . "</td>";
                            ?>
                            <td><a href="edit_library_item.php?item_id=<?php echo($row["item_id"]); ?>" class="btn btn-outline-success">Edit</a></td>
                            <td><a href="delete_library_item.php?item_id=<?php echo($row["item_id"]); ?>" class="btn btn-outline-danger">Delete</a></td>
                            <?php
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='15'>No items found.</td></tr>";
                    }
                    ?>
                    </tbody>
            </table>
        </div>
        
        <div class="pagination">
            <?php
            // Pagination links
            $sql = "SELECT COUNT(*) AS total FROM tbl_library_item";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $totalItems = $row['total'];
            $totalPages = ceil($totalItems / $itemsPerPage);

            echo "<p>Showing <big style='color:#3C91E6;'>$itemsPerPage</big> items per page of <big style='color:#3C91E6;'>$totalItems</big> total items.</p>&emsp;";
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
