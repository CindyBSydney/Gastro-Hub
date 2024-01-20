<?php
// Include the database connection file
include("../../AUTH/connection.php");

$link = connect();

// Retrieve the search query from the GET parameters
$searchQuery = $_GET['search_query'];

// Prepare the SQL query to search for patients either by first name or last name
$query = "SELECT * FROM tbl_patient WHERE first_name LIKE '%$searchQuery%' OR last_name LIKE '%$searchQuery%' ORDER BY patient_id DESC LIMIT 5";

// Execute the query
$result = mysqli_query($link, $query);

// Check if any results were found
if (mysqli_num_rows($result) > 0) {
    ?>
    <table>
        <thead>
            <tr>
                <th>Patient Name</th>
                <!-- <th>Guardian Name</th> -->
                <th>Age (yrs)</th>
                <th>Phone Number</th>
                <th>Insurance Status</th>
                <th>Triage Queue</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Loop through each row and display the item details
            while ($row = mysqli_fetch_assoc($result)) {
                $patient_id = $row["patient_id"];
                $first_name = $row["first_name"];
                $last_name = $row["last_name"];
                $full_name = $first_name . " " . $last_name;
                // // If guardian name is null, set $guardian_name to 'Does not apply'
                // if($row["guardian_name"] == ""){
                //     $guardian_name = "Does not apply";
                // } else {
                //     $guardian_name = $row["guardian_name"];
                // }
                $guardian_name = $row["guardian_name"];
                $dob = $row["dob"];
                $dobDateTime = DateTime::createFromFormat('d/m/Y', $dob);
                $currentDate = new DateTime();
                $ageInterval = $currentDate->diff($dobDateTime);
                $age = $ageInterval->y;
                $phone_number = $row["phone_number"];
                // Display the phone number in the format +(254)-123-456-789
                $phone_number_formatted = substr($phone_number, 0, 1) . "(" . substr($phone_number, 1, 3) . ")-" . substr($phone_number, 4, 3) . "-" . substr($phone_number, 7, 3) . "-" . substr($phone_number, 10);
                $insured = $row["insured"];
                ?>
                    <tr>
                        <td style="text-align:center;"><?php echo($full_name); ?></td>
                        <!-- <td style="text-align:center;"><?php //echo($guardian_name); ?></td> -->
                        <td style="text-align:center;"><?php echo($age); ?></td>
                        <td style="text-align:center;text-decoration:underline;"><a href="tel:<?php echo($phone_number); ?>"><?php echo($phone_number_formatted); ?></a></td>
                        <?php
                            if($insured == 1){
                                ?>
                                <td style="text-align:center;"><div class="status completed">Insured</div></td>
                                <?php
                            } else if($insured == 0){
                                ?>
                                <td style="text-align:center;"><div class="status process">Not Insured</div></td>
                                <?php
                            }
                        ?>
                        <!-- Check in patient by setting the visit_status to 1 -->
                        <td style="text-align:center;"><button onclick="window.location.href='add_to_queue.php?patient_id=<?php echo($patient_id); ?>'">Add to queue</button></td>
                    </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?php
} else {
    echo "No patient found.";
}

// Close the database connection
mysqli_close($link);
?>
