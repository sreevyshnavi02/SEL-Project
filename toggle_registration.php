<?php

    include 'header.php';

    // Get the type and status from the AJAX call
    $type = $_POST['type'];
    $status = $_POST['status'];
    echo "request for $type to $status";

    // Set the start date and end date based on the status
    if ($status == 'enable') {
        $start_date = date('Y-m-d H:i:s');
        $end_date = null;
    } else {
        $end_date = date('Y-m-d H:i:s');
    }

    // Get the session from the user's session variable
    $session = $_SESSION['chosen_session'];

    // Insert or update the registration track record
    if($status == 'enable'){
        $sql = "INSERT INTO u_registration_track (registration_type, start_date, end_date, allotment_date, session)
            VALUES ('$type', '$start_date', '$end_date', null, '$session')
            ON DUPLICATE KEY UPDATE start_date='$start_date', end_date='$end_date'";
    }
    else{
        $sql = "UPDATE u_registration_track SET end_date='$end_date' WHERE registration_type='$type' AND session='$session'";
    }
    $result = $conn->query($sql);
    if($result != false) {
        // Return a success response to the AJAX call
        echo "$status";
    } else {
        // Return an error response to the AJAX call
        echo "ERROR!!";
    }

?>
