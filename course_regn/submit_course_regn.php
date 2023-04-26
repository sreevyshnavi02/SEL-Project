<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTU-COE</title>
</head>
<body>
    <?php include '../header.php'; ?>
    
    <h2 style="text-align: center">You have successfully registered for the courses! All the best!</h2>

    <!-- regno, course_code, sem, faculty_id, faculty_id2 -->
    <?php
    if (isset($_POST['data'])) {
        // Get the data from the $_POST variable
        $data = $_POST['data'];

        // Looping through each row of data and inserting to the db
        foreach ($data as $row) {
            // print_r($row);
            // echo "<br>";
            $course_code = $row[0];
            $fac1 = $row[1];
            $fac2 = $row[2];
            $sql = "INSERT INTO u_course_regn(regno, session, sem, course_code, faculty_id, faculty_id2) 
        VALUES(:regno, :session, :curr_sem, :course_code, :fac1, :fac2)";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':regno', $_SESSION['regno']);
            $stmt->bindParam(':session', $_SESSION['session']);
            $stmt->bindParam(':curr_sem', $_SESSION['curr_sem']);
            $stmt->bindParam(':course_code', $course_code);

            if (isset($fac1)) {
                $stmt->bindParam(':fac1', $fac1);
            } else {
                $stmt->bindValue(':fac1', '0');
            }

            if (isset($fac2)) {
                $stmt->bindParam(':fac2', $fac2);
            } else {
                $stmt->bindValue(':fac2', '0');
            }

            // if ($stmt->execute()) {
            //     pass;
            // } else {
            //     echo "Error inserting data: " . $stmt->errorInfo()[2];
            // }

        }
    } 
    else {
        // Handle the error
        echo "No data entered!";
    }
    
    
    ?>
</body>
</html>