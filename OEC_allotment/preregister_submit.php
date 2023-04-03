<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTU-COE</title>
</head>
<body>
    <!-- add 1 to the num of students enrolled in u_prgm_elective table -->
    <?php 
    include '../header.php';
    
    $course_code = filter_var($_POST['oec_choose'], FILTER_SANITIZE_STRING);
    $chosen_session = filter_var($_SESSION['chosen_session'], FILTER_SANITIZE_STRING);

    // Prepare the statement
    $stmt = $conn->prepare("UPDATE u_prgm_elective_course 
    SET NO_OF_STUDENTS_ENROLLED = NO_OF_STUDENTS_ENROLLED + 1 
    WHERE course_code = :course_code 
    AND session = :chosen_session");

    // Bind the parameters
    $stmt->bindParam(':course_code', $course_code);
    $stmt->bindParam(':chosen_session', $chosen_session);

    // Execute the statement
    $stmt->execute();

    echo('Update executed');

    ?>

    <!-- insert the entered course into the oec_allotment table -->
    <?php
        // define the values you want to insert into the table
        // $allotment_date = date('d-m-Y H:i:s');
        // echo $allotment_date;

        // prepare the SQL query using named parameters
        $sql = "INSERT INTO u_oec_allotment (regno, course_code, session, allotment_date) 
                VALUES (:regno, :course_code, :session, NOW())";
        $stmt = $conn->prepare($sql);

        // bind the values to the named parameters in the prepared statement
        $stmt->bindParam(':regno', $_SESSION['regno']);
        $stmt->bindParam(':course_code', $course_code);
        $stmt->bindParam(':session', $chosen_session);
        // $stmt->bindParam(':allotment_date', $allotment_date);

        // execute the prepared statement to insert the row into the table
        $stmt->execute();

        // display a success message or handle any errors
        echo "Row inserted successfully.";
        header('Location: oec_allotment_order.php');
    ?>

</body>
</html>





