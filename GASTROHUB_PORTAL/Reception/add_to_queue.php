<?php
include_once '../../AUTH/connection.php';

$patient_id = $_GET['patient_id'];

try {
    // Start by trying to add the patient to tbl_patient_visit
    $query = "SELECT triage_queue_number FROM tbl_patient_visit ORDER BY triage_queue_number DESC LIMIT 1";
    $result = getData($query);

    if ($result) {
        $triage_queue_number = $result['triage_queue_number'] + 1;
    } else {
        $triage_queue_number = rand(30, 100);
    }

    $visit_status = 1;

    $query = "INSERT INTO tbl_patient_visit(patient_id, triage_queue_number, visit_status) VALUES('$patient_id', '$triage_queue_number', '$visit_status')";
    $result = setData($query);

    if ($result) {
        // get the patient's first name
        $patient_sql = "SELECT * FROM tbl_patient WHERE patient_id = '$patient_id'";
        $patient_result = getData($patient_sql);

        if ($patient_result) {
            $first_name = $patient_result['first_name'];
            $last_name = $patient_result['last_name'];
            $full_name = $first_name . " " . $last_name;
            echo "<script>alert('Patient $full_name has been added to the triage queue!'); window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Patient information not found!'); window.location.href='search.php';</script>";
        }
    }
} catch (mysqli_sql_exception $e) {
    // Check if the error message indicates a duplicate entry error
    if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
        echo "<script>alert('This patient is already in the triage queue!'); window.location.href='search.php';</script>";
    } else {
        echo "<script>alert('An error occurred while processing the request. Please try again later.'); window.location.href='search.php';</script>";
    }
}
?>
