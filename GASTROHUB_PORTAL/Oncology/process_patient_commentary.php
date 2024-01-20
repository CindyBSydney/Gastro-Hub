<?php
    include("../../AUTH/connection.php");

    // Get the oncologist's user_id
    $user_id = $_SESSION['user_id'];
    // Get the patient form data
    $patient_commentary_id = $_POST['patient_commentary_id'];
    $triage_record_id = $_POST['triage_record_id'];
    $patient_visit_id = $_POST['patient_visit_id'];
    $patient_id = $_POST['patient_id'];
    $oncologist_general_comment = $_POST['oncologist_general_comment'];
    $cancer_detection = $_POST['cancer_detection'];

    // Update the patient's commentary record
    $query = "UPDATE tbl_patient_commentary SET oncologist_general_comment='$oncologist_general_comment', cancer_detection_approval='$cancer_detection' WHERE patient_commentary_id='$patient_commentary_id'";
    $result = setData($query);

    // If the cancer detection is 1, update the patient's visit_status to 3 (i.e., patient has been diagnosed)
    if ($cancer_detection == 1) {
        $query2 = "UPDATE tbl_patient_visit SET visit_status='3' WHERE patient_visit_id='$patient_visit_id'";
        $result2 = setData($query2);
    } else {
        $query2 = "UPDATE tbl_patient_visit SET visit_status='8' WHERE patient_visit_id='$patient_visit_id'";
        $result2 = setData($query2);
    }

    // Get the radiologist_queue_number from the most recent patient record in tbl_patient_visit
    $query3 = "SELECT MAX(radiologist_queue_number) as max_queue_number FROM tbl_patient_visit";
    $result3 = getData($query3);

    if ($result3) {
        $max_queue_number = $result3['max_queue_number'];
        // If the number is 0, set the queue number to a random number between 30 and 100
        if ($max_queue_number == 0) {
            $radiologist_queue_number = rand(30, 100);
        } else {
            // Else, increment the queue number by 1
            $radiologist_queue_number = $result3['max_queue_number'] + 1;
        }

    } else {
        $radiologist_queue_number = rand(30, 100);
    }

    $query4 = "UPDATE tbl_patient_visit SET radiologist_queue_number='$radiologist_queue_number' WHERE patient_visit_id='$patient_visit_id'";
    $result4 = setData($query4);

    // Set the processing status of the nurse to 0 (i.e., nurse is no longer processing a patient)
    $query5 = "UPDATE tbl_user SET processing='0' WHERE user_id='$user_id'";
    $result5 = setData($query5);

    // If the patient's triage record was updated successfully, redirect to the dashboard
    if ($result && $result2 && $result3 && $result4 && $result5) {
        echo("<script>
            window.location.href='dashboard.php';
            alert('Patient commentary submitted successfully.');
            </script>");
    } else {
        echo("<script>
            window.location.href='dashboard.php';
            alert('Patient commentary update failed. Please try again.');
            </script>");
    }
?>
