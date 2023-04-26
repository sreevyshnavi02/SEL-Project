<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTU-COE</title>
</head>
<body>

    <?php
        include '../header.php';
        if (isset($_POST['data'])) {
            // Get the data from the $_POST variable
            $data = $_POST['data'];

            echo "<h1>Data inserted succesfully!</h1>";

            // Looping through each row of data and inserting to the db
            foreach ($data as $row) {
                // print_r($row);
                echo "<br>";
                $course_code = $row[0];
                $course_name = $row[1];
                $dept_id = $row[2];
                $credits = $row[3];
                $capacity = $row[4];
                $sess = $_SESSION['chosen_session'];


                //TEMP 
                // -----------------------remove later-------------------------

                $check_duplicate= $conn -> query("select * from u_prgm_elective_course where session = '$sess' and course_code = '$course_code';");
                $n = $check_duplicate -> rowCount();

                if($n > 0){
                    //update the table if the course code is already in the table in that session
                    $update_sql = "update u_prgm_elective_course set capacity = :capacity ";
                    $update_sql_prepare = $conn -> prepare($update_sql);
                    $update_oec = $update_sql_prepare -> execute(
                        [
                            ':capacity' => $capacity
                        ]);

                    // echo "updated ".$course_code;
                }
                else{
                    //insert these into the u_prgm_elective_course table - if new
                    $insert_sql = "insert into u_prgm_elective_course(course_code, capacity, session) values(:course_code, :capacity, :sess);";
                    $insert_sql_prepare = $conn -> prepare($insert_sql);
                    $insert_oec = $insert_sql_prepare -> execute(
                        [
                            ':course_code' => $course_code,
                            ':capacity' => $capacity,
                            ':sess' => $sess
                        ]);
                        
                        // echo "executed insert";
                }
            }
        } 
        else {
            // Handle the error
            echo "No data entered!";
        }
    ?>

    <button class="small_btn" onclick="goback()">Back</button>

    <script>
        function goback() {
            window.location.href = "../admin.php";
        }
    </script>
    
</body>
</html>