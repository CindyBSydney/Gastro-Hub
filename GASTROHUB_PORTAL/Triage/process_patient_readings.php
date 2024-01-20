<?php
    include("../../AUTH/connection.php");

    // Get the nurse's user_id
    $user_id = $_SESSION['user_id'];
    // Get the patient form data from the triage
    $patient_id = $_POST['patient_id'];
    $blood_type = $_POST['blood_type'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $blood_pressure_systolic = $_POST['blood_pressure_systolic'];
    $blood_pressure_diastolic = $_POST['blood_pressure_diastolic'];
    $temperature = $_POST['temperature'];
    $signs_and_symptoms = $_POST['signs_and_symptoms'];
    $patient_visit_id = $_POST['patient_visit_id'];
    $triage_record_id = $_POST['triage_record_id'];

    // Update the patient's triage record
    $query = "UPDATE tbl_triage SET blood_type='$blood_type', height='$height', weight='$weight', blood_pressure_systolic='$blood_pressure_systolic', blood_pressure_diastolic='$blood_pressure_diastolic', temperature='$temperature', signs_and_symptoms='$signs_and_symptoms' WHERE patient_id='$patient_id' AND triage_record_id='$triage_record_id'";
    $result = setData($query);

    // Update the patient's visit_status to 2 (i.e., patient has been triaged)
    $query2 = "UPDATE tbl_patient_visit SET visit_status='2' WHERE patient_visit_id='$patient_visit_id'";
    $result2 = setData($query2);

    // Get the oncologist_queue_number from the most recent patient record in tbl_patient_visit
    $query3 = "SELECT MAX(oncologist_queue_number) as max_queue_number FROM tbl_patient_visit";
    $result3 = getData($query3);

    if ($result3) {
        $max_queue_number = $result3['max_queue_number'];
        // If the number is 0, set the queue number to a random number between 30 and 100
        if ($max_queue_number == 0) {
            $oncologist_queue_number = rand(30, 100);
        } else {
            // Else, increment the queue number by 1
            $oncologist_queue_number = $result3['max_queue_number'] + 1;
        }

    } else {
        $oncologist_queue_number = rand(30, 100);
    }

    $query4 = "UPDATE tbl_patient_visit SET oncologist_queue_number='$oncologist_queue_number' WHERE patient_visit_id='$patient_visit_id'";
    $result4 = setData($query4);

    // Set the processing status of the nurse to 0 (i.e., nurse is no longer processing a patient)
    $query5 = "UPDATE tbl_user SET processing='0' WHERE user_id='$user_id'";
    $result5 = setData($query5);

    // If the patient's triage record was updated successfully, redirect to the dashboard
    if ($result && $result2 && $result3 && $result4 && $result5) {
        echo("<script>
            window.location.href='dashboard.php';
            alert('Patient readings updated successfully.');
            </script>");
    } else {
        echo("<script>
            window.location.href='dashboard.php';
            alert('Patient readings update failed. Please try again.');
            </script>");
    }
?>
