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
                <th>Signs & Symptoms</th>
                <th>Insurance Status</th>
                <th>Patient Details</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Loop through each row and display the item details
            while ($row = mysqli_fetch_assoc($result)) {
                // Get patient_id from tbl_patient
                $patient_id = $row["patient_id"];

                // Get patient's latest visit_status from tbl_patient_visit
                $query1 = "SELECT * FROM tbl_patient_visit WHERE patient_id = '$patient_id' ORDER BY patient_visit_id DESC LIMIT 1";
                $result1 = getData($query1);

                if($result1){
                    $visit_status = $result1["visit_status"];
                    // If the patient's visit_status is 2, display the patient's details
                    if($visit_status == 2){
                        // Fetch patient data from tbl_triage
                        $query2 = "SELECT * FROM tbl_triage WHERE patient_id = " . $row["patient_id"] . " ORDER BY triage_record_id DESC LIMIT 1";
                        $result2 = getData($query2);
                        $signs_and_symptoms = $result2["signs_and_symptoms"];
                        $patient_id = $row["patient_id"];
                        $first_name = $row["first_name"];
                        $last_name = $row["last_name"];
                        $full_name = $first_name . " " . $last_name;
                        $guardian_name = $row["guardian_name"];
                        $dob = $row["dob"];
                        $dobDateTime = DateTime::createFromFormat('d/m/Y', $dob);
                        $currentDate = new DateTime();
                        $ageInterval = $currentDate->diff($dobDateTime);
                        $age = $ageInterval->y;
                        $insured = $row["insured"];
                        ?>
                            <tr>
                                <td style="text-align:center;"><?php echo($full_name); ?></td>
                                <!-- <td style="text-align:center;"><?php //echo($guardian_name); ?></td> -->
                                <td style="text-align:center;"><?php echo($age); ?></td>
                                <td style="text-align:center;"><?php echo($signs_and_symptoms); ?></td>
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
                                <td style="text-align:center;"><button onclick="window.location.href='patient_details.php?patient_id=<?php echo($patient_id); ?>'">View details</button></td>
                            </tr>
                        <?php
                    }
                }
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
