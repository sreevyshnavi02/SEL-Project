<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTU-COE</title>
    <link rel="stylesheet" href="exam_regn_form_style.css">
</head>
<body>
    <?php 
    include '../header.php';
    
    // getting the session chosen by the user
    $year =  $_POST['session_year'];
    $formatted_year = $year[strlen($year) - 2].$year[strlen($year) - 1];
    $_SESSION['chosen_session'] = $formatted_year.$_POST['session_month'];  

    $regno = $_SESSION['regno'];

    //Fetching arrear courses
    $sql = "SELECT course_code, session
    FROM u_external_marks
    WHERE regno = '$regno'
    AND grade IN ('F', 'Z')
    AND course_code NOT IN (
        SELECT course_code
        FROM u_external_marks
        WHERE regno = '$regno'
        AND grade NOT IN ('F', 'Z')
    )";

    // Execute the query and fetch results
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $n = $stmt -> rowCount();

    if($n == 0){
        echo "$n";
        header(exam_reg.php);
    }
    else{
        //display the arrear courses
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        ?>
        <form action="exam_reg.php" method="post">

        <h3>Select the arrear courses you want to register for:</h3>
        
        <?php
        foreach ($rows as $row) {
            echo '<label><input type="checkbox" name="arrear_courses[]" value="' . $row['course_code'] . '"> ' . $row['course_code'] . ' - ' . fetch_course_name($conn, $row['course_code']) . '</label><br>';
        }
        ?>

        <input type="submit" name="submit" value="Register Selected Courses">
        </form>

    <?php
    }

    function fetch_course_name($conn, $course_code){
        $sql = "select course_name from u_course where course_code = '$course_code'";
        $query = $conn -> query($sql);
        $query -> execute();

        $result = $query -> fetchAll(PDO::FETCH_ASSOC);
        return $result[0]['course_name'];
    }
    ?>
</body>
</html>