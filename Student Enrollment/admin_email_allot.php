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
            // echo $prefix."<br>";
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
        // echo "result = ".$result." when email = ".$prefix.$suffix.$extension."<br>";
        $suffix++;
        // echo "suffix = ".$suffix."<br>";
    } while ($result);

    $suffix --;

    // Update student's email id in the database
    $stmt = $conn->prepare("UPDATE u_student SET EMAIL=:email WHERE REGNO=:regno");
    if($suffix > 0){
        $email = $prefix.$suffix.$extension;
    }
    else{
        $email = $prefix.$extension;
    }
    $stmt->execute(['email' => $email, 'regno' => $student['REGNO']]);
    // echo "updated the email ".$email."<br>";
}

echo "<h1 style='text-align: center;'>Institution Email IDs generated successfully.</h1>";

// Function to get department ID from u_prgm table
function get_dept_id($conn, $prgm_id) {
    $query = "SELECT dept_id FROM u_prgm WHERE prgm_id = :prgm_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':prgm_id', $prgm_id);
    $stmt->execute();
    $dept_id = $stmt->fetchColumn();
    return $dept_id;
}

$students_q = $conn->prepare("SELECT REGNO, SNAME, EMAIL, PRGM_ID, YOJ, entry_mode FROM u_student WHERE YOJ=:yoj ORDER BY SNAME ASC, DOB ASC");
$students_q->bindParam(':yoj', $yoj);
$students_q->execute();

$students = $students_q->fetchAll(PDO::FETCH_ASSOC);

echo("
    <table class='students_regno_table'>
    <tr>
        <th>Regno</th>
        <th>Name</th>
        <th>Assigned Email ID</th>
    </tr>");
foreach($students as $s){
    echo("
    <tr>
        <td>".$s['REGNO']."</td>
        <td>".$s['SNAME']."</td>
        <td>".$s['EMAIL']."</td>
    </tr>");
}
echo("</table>");

?>

<button class="small_btn" onclick="goback()">Back</button>

<script>
function goback() {
    window.location.href = "../admin.php";
}
</script>

