<?php
include '../connection.php';
echo("<script>console.log('checking')</script>");
    $application_no = $_REQUEST['q'];
    if(strlen($application_no) != 0){
        $check_application_no = "select * from student where application_no = $application_no;";
        $application_no_result = mysqli_query($conn,$check_application_no );
        if(mysqli_num_rows($application_no_result) > 0) {
            echo("Application number already exists");
        }
    }
?>