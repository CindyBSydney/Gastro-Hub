<?php
include("../../AUTH/connection.php");

// Add a new patient
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$guardian_first_name = $_POST['guardian_first_name'];
$guardian_last_name = $_POST['guardian_last_name'];
$guardian_full_name = $guardian_first_name . " " . $guardian_last_name;
$dob = $_POST['reg_dob'];
// Change the date format from type date to dd/mm/yyyy
$dob = date("d/m/Y", strtotime($dob));
$phone_number = $_POST['reg_phone_number'];
$insured = $_POST['reg_insured'];

$query = "INSERT INTO tbl_patient(first_name, last_name, guardian_name, dob, phone_number, insured) VALUES('$first_name', '$last_name', '$guardian_full_name', '$dob', '$phone_number', '$insured')";
$result = setData($query);

// If the patient was added successfully, retrieve the patient_id
if ($result) {
    // Retrieve the patient_id based on their unique details (e.g., full name and date of birth)
    $retrieve_query = "SELECT patient_id FROM tbl_patient WHERE first_name='$first_name' AND last_name='$last_name' AND dob='$dob'";
    $patient_result = getData($retrieve_query);

    if ($patient_result && !empty($patient_result['patient_id'])) {
        $patient_id = $patient_result['patient_id'];

        // Start by trying to add the patient to tbl_patient_visit
        $query = "SELECT triage_queue_number FROM tbl_patient_visit ORDER BY triage_queue_number DESC LIMIT 1";
        $result = getData($query);

        if ($result) {
            $triage_queue_number = $result['triage_queue_number'] + 1;
        } else {
            $triage_queue_number = rand(30, 100);
        }
        $visit_status = 1;

        // Add the patient to tbl_patient_visit
        $queue_query = "INSERT INTO tbl_patient_visit(patient_id, triage_queue_number, visit_status) VALUES('$patient_id', '$triage_queue_number', '$visit_status')";
        $queue_result = setData($queue_query);

        if ($queue_result) {
            echo("<script>
                window.location.href='dashboard.php';
                alert('Patient registered successfully and added to the triage queue.');
                </script>");
        } else {
            echo("<script>
                window.location.href='register_patient.php';
                alert('Patient registration successful, but addition to the triage queue failed. Please try again.');
                </script>");
        }
    } else {
        echo("<script>
            window.location.href='register_patient.php';
            alert('Patient information retrieval failed. Please try again.');
            </script>");
    }
} else {
    echo("<script>
        window.location.href='register_patient.php';
        alert('Patient registration failed. Please try again.');
        </script>");
}
?>
