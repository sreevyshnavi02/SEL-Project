<?php 

include '../header.php';
// Fetch students admitted in a particular semester
$yoj = $_POST['yoj'];
$stmt = $conn->prepare("SELECT REGNO, SNAME FROM u_student WHERE YOJ=:yoj and email is NULL");
$stmt->execute(['yoj' => $yoj]);
$students = $stmt->fetchAll();

// Generate email ids for each student
foreach ($students as $student) {
    echo $student['SNAME'];
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
    $stmt = $conn->prepare("SELECT REGNO FROM u_student WHERE EMAIL=:email");
    do {
        $stmt->execute(['email' => $prefix.$suffix.$extension]);
        $result = $stmt->rowCount();
        echo "result = ".$result." when email = ".$prefix.$suffix.$extension."<br>";
        $suffix++;
        echo "suffix = ".$suffix."<br>";
    } while ($result);

    $suffix --;

    // Update student's email id in the database
    $stmt = $conn->prepare("UPDATE u_student SET EMAIL=:email WHERE REGNO=:regno");
    $email = $prefix.$suffix.$extension;
    $stmt->execute(['email' => $email, 'regno' => $student['REGNO']]);
    echo "updated the email ".$email."<br>";
}

?>
