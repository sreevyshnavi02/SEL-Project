<?php

include 'header.php';
// Get the list of newly admitted students whose regno is in the form 'NEW*'
$query = "SELECT * FROM u_student WHERE regno LIKE 'NEW%'";
$stmt = $conn->prepare($query);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Loop through the list of students and generate their registration number
foreach ($students as $student) {
    $yoj = date('Y') - $student['YOJ']; // Calculate year of joining
    $dept_id = get_dept_id($conn, $student['PRGM_ID']); // Get department ID from u_prgm table
    $entry_mode = ($student['ENTRY_MODE'] == 'R') ? '1' : '2'; // Determine entry mode (1 for R, 2 for L)
    $roll_num = get_roll_num($conn, $student['YOJ'], $student['PRGM_ID']); // Get roll number for the student
    
    // Construct the registration number
    $regno = $yoj . $dept_id . $entry_mode . $roll_num;

    // Update the student's regno in the database
    $update_query = "UPDATE u_student SET regno = :regno WHERE regno = :old_regno";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bindParam(':regno', $regno);
    $update_stmt->bindParam(':old_regno', $student['REGNO']);
    $update_stmt->execute();
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

// Function to get the roll number for the student
function get_roll_num($conn, $yoj, $prgm_id) {
    $query = "SELECT COUNT(*) AS num_students FROM u_student WHERE yoj = :yoj AND prgm_id = :prgm_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':yoj', $yoj);
    $stmt->bindParam(':prgm_id', $prgm_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $roll_num = str_pad($result['num_students'] + 1, 3, '0', STR_PAD_LEFT);
    return $roll_num;
}
?>
