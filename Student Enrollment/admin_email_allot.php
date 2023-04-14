<?php 

include '../header.php';
// Fetch students admitted in a particular semester
$stmt = $pdo->prepare("SELECT REGNO, SNAME FROM u_student WHERE YOJ=:yoj AND CURR_SEM=:sem");
$stmt->execute(['yoj' => $yoj, 'sem' => $sem]);
$students = $stmt->fetchAll();

// Generate email ids for each student
foreach ($students as $student) {
    $name_parts = explode(" ", $student['SNAME']);
    $prefix = "";
    foreach ($name_parts as $part) {
        if (strlen($prefix) + strlen($part) <= 30) {
            $prefix .= strtolower(substr($part, 0, 1));
        }
    }

    // Check if email id already exists
    $suffix = "";
    $email = $prefix . "@ptuniv.edu.in";
    $stmt = $pdo->prepare("SELECT REGNO FROM u_student WHERE EMAIL=:email");
    do {
        $stmt->execute(['email' => $email . $suffix]);
        $result = $stmt->fetch();
        $suffix++;
    } while ($result);

    // Update student's email id in the database
    $stmt = $pdo->prepare("UPDATE u_student SET EMAIL=:email WHERE REGNO=:regno");
    $stmt->execute(['email' => $email . $suffix, 'regno' => $student['REGNO']]);
}

?>
