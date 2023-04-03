<?php
include '../connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTU-COE</title>
</head>
<body>
    <script>
        console.log("ajax req");
    </script>
<?php
    $course_code = $_REQUEST['request'];
    if(strlen($course_code) != 0){
        $check_course_code = "select * from u_course where course_code = '$course_code';";
        $result = mysqli_query($conn,$check_course_code );
        if(mysqli_num_rows($result) > 0) {
            foreach($result as $course){
                $json = json_encode($course);
                echo $json;
            }
        }
    }
?>

</body>
</html>