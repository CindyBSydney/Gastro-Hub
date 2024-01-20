<?php
    include_once '../../AUTH/connection.php';
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT first_name FROM tbl_user WHERE user_id = '$user_id'";
    $result = getData($sql);
    $first_name = $result['first_name'];

    $patient_id = $_GET['patient_id'];

    // Add the patient to the triage table after getting the patient_visit_id but only insert if the visit_status is not 1
    $sql = "SELECT * FROM tbl_patient_visit WHERE patient_id = '$patient_id' AND visit_status = '1' ORDER BY patient_visit_id DESC LIMIT 1";
    $result = getData($sql);

    // Check if the query returned any results
    if ($result) {
        $patient_visit_id = $result['patient_visit_id'];
        // Add the patient to the patient_visit table
        $sql2 = "INSERT INTO tbl_triage (patient_visit_id, patient_id) VALUES ('$patient_visit_id', '$patient_id')";
        $result2 = setData($sql2);

        // // If the patient_visit_id is null, then the patient has not been added to the queue yet
        // if ($patient_visit_id == null) {
        //     // Add the patient to the patient_visit table
        //     $sql2 = "INSERT INTO tbl_triage (patient_visit_id, patient_id) VALUES ('$patient_visit_id', '$patient_id')";
        //     $result2 = setData($sql2);
        // } else {
        //     echo("<script>
        //         window.location.href='dashboard.php';
        //         alert('Patient already in queue.');
        //         </script>");
        // }
    } else {
        echo("<script>
                window.location.href='dashboard.php';
                alert('Error fetching patient_visit_id.');
                </script>");
    }
    // $sql = "SELECT patient_visit_id FROM tbl_patient_visit WHERE patient_id = '$patient_id' DESC LIMIT 1";
    // $result = getData($sql);
    // $patient_visit_id = $result['patient_visit_id'];

    // $sql2 = "INSERT INTO tbl_triage (patient_visit_id, patient_id) VALUES ('$patient_visit_id', '$patient_id')";
    // $result2 = setData($sql2);

    // Set the processing status of the nurse to 1 (i.e., processing)
    $sql3 = "UPDATE tbl_user SET processing='1' WHERE user_id='$user_id'";
    $result3 = setData($sql3);

    // If all is in order, redirect to patient_readings.php
    if($result && $result2 && $result3){
        echo("<script>
            window.location.href='patient_readings.php?patient_id=$patient_id';
            </script>");
    } else {
        echo("<script>
            window.location.href='dashboard.php';
            alert('Patient not added to triage queue. Please try again later.');
            </script>");
    }
?>
