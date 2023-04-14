<?php

include '../header.php';

// Get the list of newly admitted students
$yoj = $_POST['yoj']; // year of joining to filter by
$prgm_id = $_POST['prgm_id']; // program ID to filter by

$students_q = $conn->prepare("SELECT REGNO, SNAME, DOB, PRGM_ID, YOJ, entry_mode FROM u_student WHERE YOJ=:yoj AND PRGM_ID=:prgm_id ORDER BY SNAME ASC, DOB ASC");
$students_q->bindParam(':yoj', $yoj);
$students_q->bindParam(':prgm_id', $prgm_id);
$students_q->execute();

$students = $students_q->fetchAll(PDO::FETCH_ASSOC);

$roll_num = 1;
// Loop through the list of students and generate their registration number
foreach ($students as $student) {
    $yoj = substr($student['YOJ'], 2, 2); // Calculate year of joining
    $dept_id = get_dept_id($conn, $student['PRGM_ID']); // Get department ID from u_prgm table
    $entry_mode = ($student['entry_mode'] == 'R') ? '1' : '2'; // Determine entry mode (1 for R, 2 for L)
    
    // Construct the registration number
    $roll_num_str = str_pad($roll_num, 3, '0', STR_PAD_LEFT); // Add leading zeros to roll number
    $regno = $yoj . $dept_id . $entry_mode . $roll_num_str;

    echo $regno;

    // Update the student's regno in the database
    $update_query = "UPDATE u_student SET regno = :regno WHERE regno = :old_regno";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bindParam(':regno', $regno);
    $update_stmt->bindParam(':old_regno', $student['REGNO']);
    $update_stmt->execute();

    echo "updated for ".$student['REGNO'];
    $roll_num += 1;
}


echo "Registration numbers generated successfully.";

// Function to get department ID from u_prgm table
function get_dept_id($conn, $prgm_id) {
    $query = "SELECT dept_id FROM u_prgm WHERE prgm_id = :prgm_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':prgm_id', $prgm_id);
    $stmt->execute();
    $dept_id = $stmt->fetchColumn();
    return $dept_id;
}

?>
