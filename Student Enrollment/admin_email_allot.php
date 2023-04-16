<?php 

include '../header.php';
// Fetch students admitted in a particular semester
$yoj = $_POST['yoj'];
$stmt = $conn->prepare("SELECT REGNO, SNAME FROM u_student WHERE YOJ=:yoj");
$stmt->execute(['yoj' => $yoj]);
$students = $stmt->fetchAll();

// Generate email ids for each student
foreach ($students as $student) {
    $name_parts = explode(" ", $student['SNAME']);
    $prefix = "";
    foreach ($name_parts as $part) {
        if (strlen($prefix) + strlen($part) <= 30) {
            $prefix .= strtolower($part);
            $prefix .= '.';
            echo $prefix."<br>";
        }
    }
    $prefix = substr($prefix, 0, -1);

    // Check if email id already exists
    $suffix = "";
    $extension = "@ptuniv.edu.in";
    $email = $prefix . $extension;
    $stmt = $conn->prepare("SELECT REGNO FROM u_student WHERE EMAIL=:email");
    do {
        $stmt->execute(['email' => $prefix.$suffix.$extension]);
        $result = $stmt->fetch();
        $suffix++;
    } while ($result);

    // Update student's email id in the database
    $stmt = $conn->prepare("UPDATE u_student SET EMAIL=:email WHERE REGNO=:regno");
    $stmt->execute(['email' => $email . $suffix, 'regno' => $student['REGNO']]);
    echo "updated the email ".$email."<br>";
}

?>
