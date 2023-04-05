<?php
require '../connection.php';
echo("<script>console.log('checking')</script>");

$application_no = $_REQUEST['q'];

if(strlen($application_no) != 0){
    $check_application_no = "SELECT * FROM u_student WHERE appn_num = :application_no;";
    $stmt = $conn->prepare($check_application_no);
    $stmt->bindParam(':application_no', $application_no, PDO::PARAM_STR);
    $stmt->execute();

    if($stmt->rowCount() > 0) {
        echo("Application number already exists");
    }
}
?>
