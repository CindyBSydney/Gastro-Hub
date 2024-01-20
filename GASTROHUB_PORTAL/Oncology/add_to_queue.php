<?php
    include_once '../../AUTH/connection.php';
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT first_name FROM tbl_user WHERE user_id = '$user_id'";
    $result = getData($sql);
    $first_name = $result['first_name'];

    $patient_id = $_GET['patient_id'];

    // Add the patient to the triage table after getting the patient_visit_id but only insert if the visit_status is not 1
    $sql = "SELECT * FROM tbl_patient_visit WHERE patient_id = '$patient_id' AND visit_status = '2' ORDER BY patient_visit_id DESC LIMIT 1";
    $result = getData($sql);
    $patient_visit_id = $result['patient_visit_id'];

    // Select from the tbl_triage
    $sql = "SELECT * FROM tbl_triage WHERE patient_visit_id = '$patient_visit_id' ORDER BY triage_record_id DESC LIMIT 1";
    $result = getData($sql);

    // Check if the query returned any results
    if ($result) {
        $triage_record_id = $result['triage_record_id'];
        // Add the patient to the tbl_patient_commentary table
        $sql2 = "INSERT INTO tbl_patient_commentary (triage_record_id, patient_visit_id, patient_id) VALUES ('$triage_record_id', '$patient_visit_id', '$patient_id')";
        $result2 = setData($sql2);
    } else {
        echo("<script>
                window.location.href='dashboard.php';
                alert('Error fetching patient_visit_id.');
                </script>");
    }

    // Set the processing status of the oncologist to 1 (i.e., processing)
    $sql3 = "UPDATE tbl_user SET processing='1' WHERE user_id='$user_id'";
    $result3 = setData($sql3);

    // If all is in order, redirect to consultation.php
    if($result && $result2 && $result3){
        echo("<script>
            window.location.href='consultation.php?patient_id=$patient_id';
            </script>");
    } else {
        echo("<script>
            window.location.href='dashboard.php';
            alert('Patient not added to oncology queue. Please try again later.');
            </script>");
    }
?>
